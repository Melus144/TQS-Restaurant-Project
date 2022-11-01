<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_status_id' => 'exists:order_statuses,id',
            'booking_id' => 'required|exists:bookings,id',
            'recipes' => 'required|array|min:1',
            'recipes.*.recipe_id' => 'required|exists:recipes,id',
            'recipes.*.quantity' => 'required|integer',
            'recipes.*.price' => 'required|numeric'
        ];
    }
}
