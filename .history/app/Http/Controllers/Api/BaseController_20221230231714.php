<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //

    public function sendReponse($result,$message)
    {
        $response=[
            'success'=>true,
            'data'=>$result,
            'message'=>$message,
        ];

        return response()->json($response,200);
    }

    public function sendError($error,$erroMessages=[],$code = 404)
    {
       $response = [
        'success'=>false,
        'message'=>$error,
       ];

    }
}
