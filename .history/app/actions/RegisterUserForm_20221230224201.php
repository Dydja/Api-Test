<?php

namespace App\Actions;

use App\Models\User;

class RegisterUserForm {

    /**
     * @var string
     * Enregistrons nos data via de verifiactions
     */

     public function handle(array $data):User
     {
        DB::beginTransaction();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'password_confirmation' => bcrypt($data['password_confirmation']),
        ]);
        DB::commit();

        return $user;
     }

}
