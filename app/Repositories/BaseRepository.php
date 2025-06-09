<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
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
}
