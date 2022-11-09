<?php

namespace App\Admin\Users\Requests;


use Domain\Customers\Models\CustomerGroup;
use Users\Enums\DiscountType;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;
use Support\Traits\BooleanInputsTrait;


class CustomerGroupSaveRequest extends FormRequest
{
    use BooleanInputsTrait;

    protected function prepareForValidation()
    {
        $this->convertBooleans([
            'is_dealer'
        ]);
    }


    public function rules(): array
    {
        return [
            'description' => 'nullable|string',
            'general_discount' => 'nullable|numeric',
            'general_discount_type' => ['nullable', new EnumRule(DiscountType::class)],
            'is_dealer' => 'required|bool',
            'name' => [
                'required',
                'string',
                'max:255',
                $this->getMethod() === 'PATCH'
                    ? 'unique:' . (new CustomerGroup)->getTable() . ',name,' . $this->segments()[2] // id
                    : 'unique:' . (new CustomerGroup)->getTable() . ',name',
            ],
        ];
    }

    public function enums(): array
    {
        return [
            'general_discount_type' => DiscountType::class,
        ];
    }
}
