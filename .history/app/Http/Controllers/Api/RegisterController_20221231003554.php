<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Actions\RegisterUserForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        dd($validator);

        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }

        $user = $registerForm->handle(array_merge($request->except("_token")));

         $success['token'] = $user->createToken('registerToken')->plainTextToken;
         $success['utilisateur'] = $user;

        return $this->sendResponse([$success,'Enregistre avec succès'],200);

    }

    public function login(Request $request)
    {
        //Recuperons le mail de l'utilisateur
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::make($request->password,$user->password))
        {
            return response()->json("Authentification echouée",204);
        }


    }

    public function logout()
    {
        Auth::logout();
        return response()->json("Vous êtes déconnectez",200);
    }
}
