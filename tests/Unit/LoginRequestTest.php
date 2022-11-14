<?php

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

//This test is used to know that data from login request is validated correctly
//We are not testing the Authentication feature (that's on AuthenticationTest.php)
class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    //Email must exist (be registered in db) in order to validate data from request.
    //Here we create a user and then we use the email in order to validate data rules from LoginRequest.
    function create_request_emails()
    {
        User::factory()->create([
            'email' => 'prova1@gmail.com',
        ]);
        User::factory()->create([
            'email' => 'prova1@tqs.com',
        ]);
        User::factory()->create([
            'email' => 'prova1@tqsproject.com',
        ]);
        User::factory()->create([
            'email' => 'prova2@tqsproject.com',
        ]);
        User::factory()->create([
            'email' => 'proves',
        ]);
    }

    /**
     * @dataProvider valid_data_provider
     */
    function test_valid_data(array $data)
    {
        if(User::where('email', 'prova1@gmail.com')->doesntExist()){
            $this->create_request_emails();
        }
        $request = new LoginRequest();
        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    function test_invalid_data(array $data)
    {
        $request = new LoginRequest();
        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
    }

    public function valid_data_provider(): array
    {
        return [
            [[
                'email' => 'prova1@gmail.com',
                'password' => 'password',
            ]],
            [[
                'email' => 'prova1@tqs.com',
                'password' => 'password',
            ]],
            [[
                'email' => 'prova1@tqsproject.com',
                'password' => 'password',
            ]],
            [[
                'email' => 'prova2@tqsproject.com',
                'password' => 'password',
            ]],
        ];
    }

    function invalid_data_provider(): array
    {
        return [
            [[]],
            [[
                'email' => 'prova2@tqsproject.com',
            ]],
            [[
                'password' => 'password',
            ]],
            [[
                'email' => 'proves',
                'password' => 'password',
            ]],
            [[
                'email' => 'fake_email@tqsproject.com',
                'password' => 'password',
            ]],
        ];
    }
}
