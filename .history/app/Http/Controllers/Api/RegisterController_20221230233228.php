<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Actions\RegisterUserForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class RegisterController extends BaseController
{
    //

    public function register(Request $request,RegisterUserForm $registerForm)
    {
        $validator =Validator::make($request->all,[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'c_password'=>'required|same:password',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }

        $user = $registerForm->handle(array_merge($request->except("_token")));
         $success['token'] = $user->createToken('registerToken')->plainTextToken;
         $success['utilisateur'] = $user;
        return $this->sendResponse([$success,'Enregistre avec succès'],200);

    }
}
