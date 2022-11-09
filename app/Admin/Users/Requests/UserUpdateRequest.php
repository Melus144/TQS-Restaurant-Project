<?php

namespace App\Admin\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateRequest
 *
 * @package \App\Admin\Users\Requests
 */
class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|same:password_confirmation|required_with:password_confirmation'
        ];
    }
}
