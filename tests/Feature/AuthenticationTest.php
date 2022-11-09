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
        $user = User::factory()->create([
            'email' => 'adri@gmail.com',
            'password' => Hash::make('adritqs')
        ]);

        $response = $this->postJson(route('admin.login'), [
            'email' => 'adri@gmail.com',
            'password' => 'adritqs',
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

    function test_authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(route('admin.logout'));

        $response->assertOk();
    }

    function test_guest_user_can_not_logout()
    {
        $response = $this->postJson(route('admin.logout'));

        $response->assertUnauthorized();
    }
}
