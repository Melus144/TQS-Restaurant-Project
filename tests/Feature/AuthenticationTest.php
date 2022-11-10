<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    function test_guest_user_can_login()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'adrimelus@gmail.com',
            'password' => ('$2y$10$/UHAlBUc2z3f.lA8h/FqjO0soO5ANBsJxFP5Q6uPEDgEJ82pib5AS')
        ]);

        $response->assertOk();
    }

    function test_guest_user_can_not_login_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'adri@tqsproject.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson(route('admin.login'), [
            'email' => 'adri@tqsproject.com',
            'password' => 'not password',
            'device_name' => 'TQS APP'
        ]);

        $response->assertUnprocessable();
    }

    public function test_interacting_with_the_session()
    {
        $response = $this->withSession(['banned' => false])->get('/');
    }

    function test_authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $user = User::factory()->create([
            'firstname' => 'Adri',
            'lastname' => 'Melus',
            'email' => 'adri@gmail.com',
            'phone' => '123456789',
            'password' => Hash::make('adritqs')
        ]);

        $response = $this->postJson(route('admin.logout'));

        $response->assertOk();
    }

    function test_guest_user_can_not_logout()
    {
        $response = $this->postJson(route('admin.logout'));

        $response->assertUnauthorized();
    }
}
