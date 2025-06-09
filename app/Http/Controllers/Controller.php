<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static function getRaw(){
		return file_get_contents("php://input");
	}

    static function getRawDecoded(){
		return json_decode(self::getRaw());
	}
    
    static function stdJson($success = true, $msg = "", $data = []){
        return [
            "success" => $success,
            "message" => $msg,
            "data" => $data
        ];
    }
	
	static function codedStdJson($success = true, $msg = "", $data = [], $code=0){
        return [
            "code" => $code,
            "success" => $success,
            "message" => $msg,
            "data" => $data
        ];
    }

    static function jsonResp($data = [], $code = null){
        $code = $code ?? 200;
        return response()->json($data, $code);
    }

    static function success($msg = "", $data = [], $code=0){
        return response()->json(self::codedStdJson(true, $msg, $data, $code), 200);
    }

    static function userFail($msg = "", $data = [], $code=0){
        return response()->json(self::codedStdJson(false, $msg, $data, $code), 400);
    }

    static function fail($msg = "", $data = [], $status = 500, $code=0){
        return response()->json(self::codedStdJson(false, $msg, $data, $code), $status);
    }
}
