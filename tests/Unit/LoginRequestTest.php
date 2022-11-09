<?php

use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        User::factory()->create([
            'email' => 'adri@tqsproject.com'
        ]);

        $request = new LoginRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        User::factory()->create([
            'email' => 'adri@tqsproject.com'
        ]);

        $request = new LoginRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {
        return [
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'device_name' => 'TQS API'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'device_name' => str_repeat('A', 1)
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'device_name' => str_repeat('A', 2)
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'device_name' => str_repeat('A', User::DEVICE_NAME_MAX_LENGTH - 1)
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'device_name' => str_repeat('A', User::DEVICE_NAME_MAX_LENGTH)
            ]]
        ];
    }

    function invalid_data_provider(): array
    {
        return [
            [[]],
            [[
                'email' => 'adri@tqsproject.com',
            ]],
            [[
                'password' => 'password',
            ]],
            [[
                'device_name' => 'TQS API'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'device_name' => 'TQS API'
            ]],
            [[
                'password' => 'password',
                'device_name' => 'TQS API'
            ]],
            [[
                'email' => 'fake_email@tqsproject.com',
                'password' => 'password',
                'device_name' => 'TQS API'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'not the real password',
                'device_name' => null
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'not the real password',
                'device_name' => ''
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'not the real password',
                'device_name' => str_repeat('A', User::DEVICE_NAME_MAX_LENGTH + 1)
            ]]
        ];
    }
}
