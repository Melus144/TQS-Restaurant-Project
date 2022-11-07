<?php

namespace Tests\Unit;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider valid_data_provider
     */
    public function test_valid_data(array $data)
    {
        $request = new RegisterRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    public function test_invalid_data(array $data)
    {
        User::factory()->create([
            'email' => 'adri@tqsproject.com'
        ]);

        $request = new RegisterRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {
        return [
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => str_repeat('A', 1),
                'email' => str_repeat('A', 1) . '@tqsproject.com',
                'password' => str_repeat('A', 1),
                'password_confirmation' => str_repeat('A', 1)
            ]],
            [[
                'name' => str_repeat('A', 2),
                'email' => str_repeat('A', 2) . '@tqsproject.com',
                'password' => str_repeat('A', 2),
                'password_confirmation' => str_repeat('A', 2)
            ]],
            [[
                'name' => str_repeat('A', User::NAME_MAX_LENGTH - 1),
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 9) . '@tqsproject.com',
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH - 1),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH - 1)
            ]],
            [[
                'name' => str_repeat('A', User::NAME_MAX_LENGTH),
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 8) . '@tqsproject.com',
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH)
            ]]
        ];
    }

    public function invalid_data_provider(): array
    {
        return [
            [[]],
            [[
                'name' => 'Adri',
            ]],
            [[
                'email' => 'adri@tqsproject.com',
            ]],
            [[
                'password' => 'password',
            ]],
            [[
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com'
            ]],
            [[
                'name' => 'Adri',
                'password' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'password_confirmation' => 'password'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => 'password'
            ]],
            [[
                'name' => null,
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => null,
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => null,
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => null
            ]],
            [[
                'name' => '',
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => '',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => '',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => ''
            ]],
            [[
                'name' => str_repeat('A', User::NAME_MAX_LENGTH + 1),
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 7) . '@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1)
            ]],
            [[
                'name' => 'Adri',
                'email' => 'adri@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'not the same password'
            ]],
        ];
    }
}
