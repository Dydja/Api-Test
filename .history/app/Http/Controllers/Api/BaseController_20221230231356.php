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
            'data'=>$result
            'message'=>$message,
        ]
    }
}
