<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Actions\RegisterUserForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\BaseController as BaseController;

class RegisterController extends BaseController
{
    //

    public function register(Request $request,RegisterUserForm $registerForm)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);


        if($validator->fails())
        {
            return $this->sendError('Validation echouées',$validator->errors());

        }

        // $user = $registerForm->handle(array_merge($request->except("_token")));

        //  $success['token'] = $user->createToken('registerToken')->plainTextToken;
        //  $success['utilisateur'] = $user;

        // return $this->sendResponse([$success,'Enregistre avec succès'],200);

    }

    public function login(Request $request)
    {
        //Recuperons le mail de l'utilisateur
        $user = User::where('email',$request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $user->createToken("Api")->plainTextToken;


    }

    public function logout()
    {
        Auth::logout();
        return response()->json("Vous êtes déconnectez",200);
    }
}
