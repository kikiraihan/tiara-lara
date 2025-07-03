<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Queue; // Use the Queue facade to get the connection
use Illuminate\Support\Str; // For UUID generation
use PhpAmqpLib\Message\AMQPMessage; // Import AMQPMessage for message creation
use DB;
use Log;

use PgSql\Lob;
use Predis\Client as PredisClient;

use Smuuf\CeleryForPhp\Celery;
use Smuuf\CeleryForPhp\TaskSignature;
use Smuuf\CeleryForPhp\Brokers\AmqpBroker;
use Smuuf\CeleryForPhp\Drivers\PredisRedisDriver;
use Smuuf\CeleryForPhp\Drivers\PhpAmqpLibAmqpDriver;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use Smuuf\CeleryForPhp\Backends\RedisBackend;


class BaseRepository implements BaseRepositoryInterface
{
    protected $cacheExpired = 300; // 6*50 = 5 minutes in seconds
    protected $mainTable = "users"; // 6*50 = 5 minutes in seconds

    protected $eventService;
    
    protected function getMainDB(){
        return DB::table($this->mainTable);
    }

    protected function reconnectAndNoStrict(){
        DB::disconnect('mysql');
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect('mysql');
    }

    public function getEventService(){
		return $this->eventService;
	}

	public function setEventService($eventService){
		$this->eventService = $eventService;

		return $this;
	}

    function sendToCeleryx() { 
        
        $c = config("queue.connections.rabbitmq.hosts.0");
        $host = $c['host'];
        $port = $c['port'];
        $user = $c['user'];
        $pwd = $c['password'];
        // Log::info($c);
        
        // wip use dep injection for amqp connection
        $amqpConn = new AMQPStreamConnection($host, 
            $port, 
            $user,
            $pwd,
            '/');
        // $amqpConn = new AMQPSSLConnection(['127.0.0.1', '5672', '', '', '/', ['verify_peer'=>false]]);
        $amqpDriver = new PhpAmqpLibAmqpDriver($amqpConn);

        // $predis = new PredisClient(['host' => 'host.docker.internal']);
        Log::info(["Redis::class", Redis::class]);
        $predis = Redis::connection();
        $redisDriver = new PredisRedisDriver($predis->client());

        $celery = new Celery(
            new AmqpBroker($amqpDriver),
            new RedisBackend($redisDriver),
            // Optionally explicit config object.
            // config: new \Smuuf\CeleryForPhp\Config(...)
        );

        $task = new TaskSignature(
            taskName: 'worker.t1',
            queue: 'celery', // Optional, 'celery' by default.
            args: [1, 3, 5],
            // kwargs: ['arg_a' => 123, 'arg_b' => 'something'],
            // eta: 'now +10 minutes',
            // ... or more optional arguments.
        );

        // Send the task into Celery.
        $asyncResult = $celery->sendTask($task);

        // Wait for the result (up to 10 seconds by default) and return it.
        // Alternatively a \Smuuf\CeleryForPhp\Exc\CeleryTimeoutException exception will
        // be thrown if the task won't finish in time.
        // $result = $asyncResult->get();
        // $result === 9
    }

    function sendToCelery() {
        // Get the RabbitMQ connection instance
        // This gives you access to the underlying PhpAmqpLib objects
        $connection = Queue::connection('rabbitmq')->getChannel()->getConnection();
        $channel = $connection->channel();

        // Get the configured queue name
        $queueName = config('queue.connections.rabbitmq.queue');
        $exchangeName = config('queue.connections.rabbitmq.options.exchange.name'); // Will be empty for default

        // ----------------------------------------------------
        // Step 1: Define Celery Task Details
        // Make sure 'your_module.celery_worker' matches your Python file's path
        // e.g., if your worker is at /app/workers/celery_app.py
        // and 'your_module' is '/app/workers', then it's 'your_module.celery_app.t1'
        // ----------------------------------------------------
        // routing_key
        $taskNameT1 = 'worker.t1';
        $argsT1 = ['hello from Laravel', 123];
        $kwargsT1 = ['source' => 'Laravel'];

        // routing_key
        $taskNameT2 = 'worker.t2';
        $argsT2 = ['another message'];
        $kwargsT2 = ['priority' => 'high'];

        // ----------------------------------------------------
        // Step 2: Construct the Celery Message Payload (JSON format)
        // ----------------------------------------------------

        // Function to create a Celery-compatible message
        $createCeleryMessage = function(string $task, array $args = [], array $kwargs = []) use ($queueName) {
            $taskId = (string) Str::uuid();

            // The 'body' of the Celery message is an array containing [args, kwargs, embeded_delivery_info]
            // This entire body array is then JSON encoded and base64 encoded.
            $celeryBodyArray = [$args, $kwargs, [
                'exchange' => '', // Celery default
                'routing_key' => $queueName,
            ]];

            // $celeryBodyEncoded = base64_encode(json_encode($celeryBodyArray));
            $celeryBodyEncoded = json_encode($celeryBodyArray);

            // Celery message headers
            $celeryHeaders = [
                'lang' => 'py',
                'task' => $task,
                'id' => $taskId,
                'root_id' => $taskId, // For single tasks, root_id is usually same as id
                'parent_id' => $taskId, // For single tasks, parent_id is usually same as id
                'group_id' => null,
                'chord' => null,
                'subtask' => null,
                'reply_to' => 'celery@' . gethostname() . '.worker', // Or your specific reply queue
                'correlation_id' => $taskId,
                'hostname' => gethostname() . '.worker',
                'retries' => 0,
                'expires' => null,
                'timelimit' => [null, null],
                'callbacks' => null,
                'errbacks' => null,
                // These are for display in Celery monitors, not strictly required for execution
                'argsrepr' => (string) base64_encode(json_encode($args)),
                'kwargsrepr' => (string) base64_encode(json_encode($kwargs)),
            ];

            // Properties for the AMQP message itself
            $properties = [
                'content_type' => 'application/json',
                // 'content_encoding' => 'binary',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT, // Make messages durable
                'headers' => new \PhpAmqpLib\Wire\AMQPTable($celeryHeaders),
            ];

            return new AMQPMessage($celeryBodyEncoded, $properties);
        };

        // Create the messages
        $messageT1 = $createCeleryMessage($taskNameT1, $argsT1, $kwargsT1);
        $messageT2 = $createCeleryMessage($taskNameT2, $argsT2, $kwargsT2);

        // ----------------------------------------------------
        // Step 3: Publish the messages
        // ----------------------------------------------------

        // For t1
        try {
            $channel->basic_publish($messageT1, $exchangeName, $queueName);
            \Log::info("Celery task {$taskNameT1} dispatched to RabbitMQ.");
        } catch (\Exception $e) {
            \Log::error("Failed to dispatch Celery task {$taskNameT1}: " . $e->getMessage());
            // return response()->json(['error' => 'Failed to dispatch T1: ' . $e->getMessage()], 500);
        }

        // For t2
        try {
            $channel->basic_publish($messageT2, $exchangeName, $queueName);
            \Log::info("Celery task {$taskNameT2} dispatched to RabbitMQ.");
        } catch (\Exception $e) {
            \Log::error("Failed to dispatch Celery task {$taskNameT2}: " . $e->getMessage());
            // return response()->json(['error' => 'Failed to dispatch T2: ' . $e->getMessage()], 500);
        }

        // ----------------------------------------------------
        // Step 4: Close the channel and connection (important!)
        // ----------------------------------------------------
        $channel->close();
        $connection->close();
        // return response()->json(['message' => 'Celery tasks dispatched directly to RabbitMQ.']);

        return 1;
    }
}
