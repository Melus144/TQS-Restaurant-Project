<?php

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateUserRequestTest extends TestCase
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
        User::factory()->create();

        $request = new RegisterRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {

        return [
            [[
                'firstname' => 'Adri',
                'lastname' => 'Melus',
                'email' => 'adri@tqsproject.com',
                'phone' => '',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => str_repeat('A', 1),
                'lastname' => str_repeat('A', 1),
                'email' => str_repeat('A', 1) . '@tqsproject.com',
                'phone' => str_repeat('1', 1),
                'password' => str_repeat('A', 1),
                'password_confirmation' => str_repeat('A', 1)
            ]],
            [[
                'firstname' => str_repeat('A', 2),
                'lastname' => str_repeat('A', 2),
                'email' => str_repeat('A', 2) . '@tqsproject.com',
                'phone' => str_repeat('1', 2),
                'password' => str_repeat('A', 2),
                'password_confirmation' => str_repeat('A', 2)
            ]],
            [[
                'firstname' => str_repeat('A', User::FIRSTNAME_MAX_LENGTH - 1),
                'lastname' => str_repeat('A', User::LASTNAME_MAX_LENGTH - 1),
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 16) . '@tqsproject.com',
                'phone' => str_repeat('1', User::PHONE_MAX_LENGTH - 1),
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH - 1),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH - 1)
            ]],
            [[
                'firstname' => str_repeat('A', User::FIRSTNAME_MAX_LENGTH),
                'lastname' => str_repeat('A', User::LASTNAME_MAX_LENGTH),
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 15) . '@tqsproject.com',
                'phone' => str_repeat('1', User::PHONE_MAX_LENGTH),
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
                'firstname' => 'Josh'
            ]],
            [[
                'lastname' => 'Youngman'
            ]],
            [[
                'email' => 'josh@tqsproject.com'
            ]],
            [[
                'password' => 'password'
            ]],
            [[
                'password_confirmation' => 'password'
            ]],
            [[
                'phone' => '1'
            ]],
            [[
                'firstname' => 'John',
                'lastname' => 'Bergmann'
            ]],
            [[
                'firstname' => 'John',
                'email' => 'john@tqsproject.com'
            ]],
            [[
                'firstname' => 'John',
                'password' => 'password'
            ]],
            [[
                'firstname' => 'John',
                'password_confirmation' => 'password'
            ]],
            [[
                'lastname' => 'Bergmann',
                'email' => 'john@tqsproject.com'
            ]],
            [[
                'lastname' => 'Bergmann',
                'password' => 'password'
            ]],
            [[
                'lastname' => 'Bergmann',
                'password_confirmation' => 'password'
            ]],
            [[
                'email' => 'josh@tqsproject.com',
                'password' => 'password'
            ]],
            [[
                'email' => 'josh@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => 'password'
            ]],
            [[
                'firstname' => null,
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => null,
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => null,
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => null
            ]],
            [[
                'name' => '',
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => '',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => '',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => ''
            ]],
            [[
                'name' => str_repeat('A', User::NAME_MAX_LENGTH + 1),
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 7) . '@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'name' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1)
            ]],
            [[
                'name' => 'Josh',
                'email' => 'josh@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'not the same password'
            ]],
        ];
    }
}
