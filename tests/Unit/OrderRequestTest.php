<?php

use App\Admin\Orders\Requests\OrderRequest;
use App\Models\Booking;
use App\Models\OrderStatus;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        OrderStatus::factory()->create();
        Booking::factory()->create();
        Recipe::factory()->count(3)->create();

        $request = new OrderRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        OrderStatus::factory()->create();
        Booking::factory()->create();
        Recipe::factory()->count(3)->create();

        $request = new OrderRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    //Test sobre dades valides que el programa pot rebre pel seu correcte funcionament
    public function valid_data_provider(): array
    {
        return [
            [[
                'order_status_id' => 1,
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ],
                    [
                        'recipe_id' => 2,
                        'quantity' => 2,
                        'price' => 29.99
                    ],
                    [
                        'recipe_id' => 3,
                        'quantity' => 1,
                        'price' => 5.49
                    ],
                ]
            ]]
        ];
    }

    //Test sobre dades invalides que generarien errors en el programa
    public function invalid_data_provider(): array
    {
        return [
            [[
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],

            [[
                'order_status_id' => 3,
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'order_status_id' => null,
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],

            //Campos con valores null o con tipos de datos incorrectos
            [[
                'booking_id' => null,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => null
            ]],
            [[
                'booking_id' => 1,
                'recipes' => []
            ]],
            [[
                'booking_id' => 'not an integer',
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => 'not an array'
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => null,
                        'quantity' => 2,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => null,
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => null
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2.5,
                        'price' => 20.50
                        
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 'not an integer',
                        'price' => 20.50
                    ]
                ]
            ]],
            [[
                'booking_id' => 1,
                'recipes' => [
                    [
                        'recipe_id' => 1,
                        'quantity' => 2,
                        'price' => 'not a numeric'
                    ]
                ]
            ]]
        ];
    }
}
