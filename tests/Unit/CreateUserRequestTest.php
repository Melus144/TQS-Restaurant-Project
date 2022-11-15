<?php
use App\Admin\Users\Requests\UserStoreRequest;
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
        $request = new UserStoreRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @dataProvider invalid_data_provider
     */
    public function test_invalid_data(array $data)
    {
        User::factory()->create();

        $request = new UserStoreRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
    }

    //Test sobre dades valides que el programa pot rebre pel seu correcte funcionament
    public function valid_data_provider(): array
    {

        return [
            [[
                'firstname' => 'New',
                'lastname' => 'User',
                'email' => 'notexistingmail@tqsproject.com',
                'phone' => '123456789',
                'password' => 'password123',
                'password_confirmation' => 'password123'
            ]],
            [[
                'firstname' => str_repeat('A', 1),
                'lastname' => str_repeat('A', 1),
                'email' => str_repeat('A', 1) . '@tqsproject.com',
                'phone' => str_repeat('1', 1),
                'password' => str_repeat('A', 8),
                'password_confirmation' => str_repeat('A', 8)
            ]],
            [[
                'firstname' => str_repeat('A', 2),
                'lastname' => str_repeat('A', 2),
                'email' => str_repeat('B', 2) . '@tqsproject.com',
                'phone' => str_repeat('1', 2),
                'password' => str_repeat('A', 9),
                'password_confirmation' => str_repeat('A', 9)
            ]],
            //Test con valores dentro del rango permitido
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

    //Test sobre dades invalides que generarien errors en el programa
    public function invalid_data_provider(): array
    {
        return [
            [[]],
            //Campos incompletos
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
                'email' => 'john2245@tqsproject.com'
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
                'email' => 'josh1@tqsproject.com',
                'password' => 'password'
            ]],
            [[
                'email' => 'josh2@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'email' => 'josh3@tqsproject.com',
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
                'email' => 'josh4@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => 'josh5@tqsproject.com',
                'password' => 'password'
            ]],
            //Campos con valores null
            [[
                'firstname' => null,
                'lastname' => 'Bergmann',
                'email' => 'josh6@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => null,
                'email' => 'josh7@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => null,
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh8@tqsproject.com',
                'password' => null,
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh9@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => null
            ]],
            [[
                'firstname' => '',
                'lastname' => 'Bergmann',
                'email' => 'josh10@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'email' => 'josh11@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh12@tqsproject.com',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh13@tqsproject.com',
                'password' => 'password',
            ]],
            //campos fuera de rango
            [[
                'firstname' => str_repeat('A', User::FIRSTNAME_MAX_LENGTH + 1),
                'lastname' => 'Bergmann',
                'email' => 'josh14@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => str_repeat('A', User::LASTNAME_MAX_LENGTH + 1),
                'email' => 'josh15@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => str_repeat('A', User::EMAIL_MAX_LENGTH - 14) . '@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]],
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh16@tqsproject.com',
                'password' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1),
                'password_confirmation' => str_repeat('A', User::PASSWORD_MAX_LENGTH + 1)
            ]],
            //Contraseñas no coincidentes
            [[
                'firstname' => 'Josh',
                'lastname' => 'Bergmann',
                'email' => 'josh17@tqsproject.com',
                'password' => 'password',
                'password_confirmation' => 'not the same password'
            ]],
        ];
    }
}
