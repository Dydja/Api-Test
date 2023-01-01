<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Actions\RegisterUserForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\UserResource;

class RegisterController extends BaseController
{
    //

    public function register(RegisterRequest $request,RegisterUserForm $registerForm)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
            'password_confirmation'=>'required|same:password'
        ]);


        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }

        $user = $registerForm->handle($request->validated());
       // dd($user);

         $success['token'] = $user->createToken('barear-token')->plainTextToken;
         $success['utilisateur'] = $user;

        return $this->sendResponse(new UserResource($success),'Enregistre avec succès');

    }

    public function login(Request $request)
    {
        // //Recuperons le mail de l'utilisateur
         $user = User::where('email',$request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
           return $this->sendError("E-mail ou mot de passe incorrect");
        }
       //Sinon on le connecte en lui retournant avec token
       $token = $user->createToken("barear-token")->plainTextToken;

       return $this->sendResponse( new UserResource($token),"Connexion réussie");


    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json("Vous êtes déconnectez",200);
    }

    //Renvoie les informations sur le compte user actuellement authentifié

    public function profile(Request $request)
    {
          return $request->user();
    }
}
