<?php

use App\Admin\Food\Requests\FoodRequest;
use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FoodRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        $request = new FoodRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        $request = new FoodRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {
        return [
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => str_repeat('A', 1),
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => str_repeat('A', 2),
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => str_repeat('A', Food::NAME_MAX_LENGTH - 1),
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => str_repeat('A', Food::NAME_MAX_LENGTH),
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => str_repeat('A', 1),
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => str_repeat('A', 2),
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => str_repeat('A', Food::UNITS_MAX_LENGTH - 1),
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => str_repeat('A', Food::UNITS_MAX_LENGTH),
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => str_repeat('A', 1)
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => str_repeat('A', 2)
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => str_repeat('A', Food::TYPE_MAX_LENGTH - 1)
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => str_repeat('A', Food::TYPE_MAX_LENGTH)
            ]]
        ];
    }

    public function invalid_data_provider(): array
    {
        return [
            [[]],
            [[
                'name' => 'foo'
            ]],
            [[
                'units' => 'kg'
            ]],
            [[
                'type' => 'foo type'
            ]],
            [[
                'name' => null,
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => null,
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => null
            ]],
            [[
                'name' => '',
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => '',
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => ''
            ]],
            [[
                'name' => str_repeat('A', Food::NAME_MAX_LENGTH + 1),
                'units' => 'kg',
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => str_repeat('A', Food::UNITS_MAX_LENGTH + 1),
                'type' => 'foo type'
            ]],
            [[
                'name' => 'foo',
                'units' => 'kg',
                'type' => str_repeat('A', Food::TYPE_MAX_LENGTH + 1)
            ]]
        ];
    }
}
