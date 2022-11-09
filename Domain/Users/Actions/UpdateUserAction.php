<?php

namespace Users\Actions;

use Users\DTOs\UserData;
use Users\Models\User;

/**
 * Class UpdateUserAction
 *
 * @package \Domain\Users\Actions
 */
class UpdateUserAction
{
    public function __invoke(User $user, UserData $data): User
    {
        $user->fill([
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'phone' => $data->phone,
            'email' => $data->email,
        ]);

        if($data->password) {
            $user->password = $data->password;
        }

        $user->save();

        return $user->refresh();
    }
}
