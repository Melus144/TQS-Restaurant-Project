<?php

use App\Http\Requests\StockRequest;
use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StockRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        Food::factory()->create();

        $request = new StockRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        Food::factory()->create();

        $request = new StockRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    //Test sobre dades valides que el programa pot rebre pel seu correcte funcionament
    public function valid_data_provider(): array
    {
        return [
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => true,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'food_id' => 1
            ]]
        ];
    }

    //Test sobre dades invalides que generarien errors en el programa
    public function invalid_data_provider(): array
    {
        return [
            [[]],
            //Test con campos incompletos
            [[
                'quantity' => 50.55
            ]],
            [[
                'expiration_date' => '2022-04-07 21:30:22'
            ]],
            [[
                'expired' => false
            ]],
            [[
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22'
            ]],
            [[
                'quantity' => 50.55,
                'expired' => false
            ]],
            [[
                'quantity' => 50.55,
                'food_id' => 1
            ]],
            [[
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false
            ]],
            [[
                'expiration_date' => '2022-04-07 21:30:22',
                'food_id' => 1
            ]],
            [[
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false
            ]],
            [[
                'quantity' => null,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => null,
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => null,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => null
            ]],
            [[
                'quantity' => 'not a double',
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            //Test con data de caducidad incompleta o con formato erroneo
            [[
                'quantity' => 50.55,
                'expiration_date' => '',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022/04/07 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '07-04-2022 21:30:22',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07',
                'expired' => false,
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => 'not a boolean',
                'food_id' => 1
            ]],
            [[
                'quantity' => 50.55,
                'expiration_date' => '2022-04-07 21:30:22',
                'expired' => false,
                'food_id' => 50
            ]],
        ];
    }
}
