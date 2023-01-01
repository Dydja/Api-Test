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

        return $this->sendResponse('Enregistre avec succès',$success);

    }

    public function login(Request $request)
    {

        if(!Auth::attempt($request->only('email','password')))
        {
            return response()->json(['message' => 'Connexion echouée', 'status' =>404]);
        }
        //Recuperons le mail de l'utilisateur
        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('barear-token')->plainTextToken;
        return $this->sendResponse($token,"Connexion réussie");


        // if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        // {
        //     $user = Auth::user();
        //     $success['token'] = $user->createToken('barear-token')->plainTextToken;
        //     $success['user'] = $user->name;

        //     return $this->sendResponse($success,"Connexion réussie");
        // }
        // else{
        //     return $this->sendError("Non autorisé",['error'=>'Echec']);
        // }

       // dd($user);

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //    return $this->sendError("E-mail ou mot de passe incorrect");
        // }
       // Sinon on le connecte en lui retournant avec token
    //    $token = $user->createToken("barear-token")->plainTextToken;

    //    return $this->sendResponse("Connexion réussie",$token);


    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json("Vous êtes déconnectez",200);
    }

    //Renvoie le compte user actuellement authentifié

    public function profile(Request $request)
    {
          return $request->user();
    }
}
