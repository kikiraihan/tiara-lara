<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;

use Illuminate\Support\Facades\Queue; // Use the Queue facade to get the connection
use Illuminate\Support\Str; // For UUID generation
use PhpAmqpLib\Message\AMQPMessage; // Import AMQPMessage for message creation
use DB;

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
        $taskNameT1 = 'worker.worker.t1';
        $argsT1 = ['hello from Laravel', 123];
        $kwargsT1 = ['source' => 'Laravel'];

        $taskNameT2 = 'worker.worker.t2';
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

            $celeryBodyEncoded = base64_encode(json_encode($celeryBodyArray));

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
                'content_encoding' => 'binary',
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
