<?php
namespace App\Repositories;

use App\Jobs\ExtractJob;
use App\Models\ModelMachineLearning;
use Illuminate\Support\Facades\Http;

use App\Repositories\BaseRepository;
use App\Repositories\Traits\CRUDRepoTrait;
use App\Models\Tickets;
use App\Models\User;
use DB;
use Arr;
use Error;
use Illuminate\Support\Facades\Log;

class InferenceRepository extends BaseRepository{
    use CRUDRepoTrait;
    protected $mainTable = "users";
    protected $method = "req";

    public function __construct(){
        $this->setModel(User::class);

        $this->setMethod(config("app.extract.method"));
    }

    function conditionalPush($t=1, $data=null){
        // push job to amqp t1
        $method  = $this->getMethod();
        $r = null;
        
        switch($method){
            case "celery":
                ExtractJob::dispatch()->onQueue('rabbitmq');
                $r = $this->sendToCeleryx();
            break;
            case "req":
            default:
                $r = $this->extract($data);
        }

        return $r;
    }

    function extract($data=null){
        $APP_FA_ML_SVC_URL = env("APP_FA_ML_SVC_URL");

        // wip use bg job
        $response = Http::baseUrl($APP_FA_ML_SVC_URL)
            ->timeout(60)
            ->asJson()->post("/v1/p/extract", $data);
        
        Log::info($response->getBody());
        Log::info($response->json());

        $response = $response->json();
        // Log::info( preout($response) );
        if($response){
            $response = $response['data'];
        }
        $response = "test infer";
        return $response;
    }

    // $t = model
    function infer($model=null, $data){
        if(!in_array($model, ModelMachineLearning::$MODELS)){
            throw new Error("Illegal model choice : $model");
        }
        
        $APP_FA_ML_SVC_URL = env("APP_FA_ML_SVC_URL");

        /* 
        $APP_MS3_ML_SVC_URL = env("APP_MS3_ML_SVC_URL");
        $flow = $data['f'];
        $action = $data['a'];
        
        $response = Http::post("{$APP_MS3_ML_SVC_URL}api/infer/infer/$flow/$action", $data);
        
        Log::info($response->getBody());
        Log::info($response->json());

        $response = $response->json();
        // Log::info( preout($response) );
        if($response){
            $response = $response['data'];
            } */
       $response = "test infer";
        return $response;
    }

    /**
     * Get the value of method
     */ 
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the value of method
     *
     * @return  self
     */ 
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }
}