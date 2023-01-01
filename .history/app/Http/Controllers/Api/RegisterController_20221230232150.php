<?php

namespace App\Http\Controllers\Api;

use App\Actions\RegisterUserForm;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //

    public function register(Request $request,RegisterUserForm $registerForm)
    {
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'c_password'=>'required',
        ]);

        $action= $registerForm->handle(array_merge($request->except("_token")));

        return response()->json([$action,'Enregistre avec succès'],200);

    }
}
