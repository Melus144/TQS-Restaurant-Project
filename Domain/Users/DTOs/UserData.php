<?php

namespace Users\DTOs;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class UserData extends DataTransferObject
{
    public string $firstname;
    public string $lastname;
    public ?string $phone;
    public string $email;
    public ?string $password;

    public ?int $userGroup;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password'=> $request->password ? Hash::make($request->password) : null,
        ]);
    }
}
