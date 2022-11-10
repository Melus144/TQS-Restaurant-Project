<?php

namespace Users\Actions;

use Users\DTOs\UserData;
use App\Models\User;
class CreateUserAction
{
    public function __invoke(UserData $data): User
    {
        $user = User::create([
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'phone' => $data->phone,
            'email' => $data->email,
            'password' => $data->password,
        ]);

        return $user;
    }
}
