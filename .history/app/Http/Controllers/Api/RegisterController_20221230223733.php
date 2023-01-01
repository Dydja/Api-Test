<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //

    public function register(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'c_password'=>'required'
        ])
    }
}
