<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    
    public function sendResponce($result,$message){
        $responce = [
            'success' => true,
            'data' => $result,
            'success' => $message,
        ];
        return  response()->json($responce,200);
    }

    public function sendError($error ,$Errormessage = [], $code = 404){
        $responce = [
            'success' => true,
            'data' => $error,
        ];
        if(!empty($Errormessage)){

            $responce['data'] = $Errormessage;

        }
        return  response()->json($responce,$code);
    }
}
