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
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'phone' => 'max:15',
            'email' => 'required|unique:users,email|max:100',
            'password' => 'nullable|min:8|same:password_confirmation|required_with:password_confirmation|max:150'
        ];
    }
}
