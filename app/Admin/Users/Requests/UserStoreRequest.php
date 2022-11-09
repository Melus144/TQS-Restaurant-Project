<?php

namespace App\Admin\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserFormRequest
 *
 * @package \App\Admin\Users\Requests
 */
class UserStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8|same:password_confirmation'
        ];
    }
}
