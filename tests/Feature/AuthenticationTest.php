<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    //Per tal de no anar omplint la base de dades real, utilitzem la funció RefreshDatabase, que esborra tots els registres de la base de dades després de cada test.
    use RefreshDatabase;

    public function test_login_form_displayed()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    function test_admin_can_send_login_post_request()
    {
            $user = User::factory()->create();
            $hasUser = $user ? true : false;
            $this->assertTrue($hasUser);
            $response = $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => $user->password,
            ]);
        $response->assertStatus(302);
    }

    function test_admin_can_login()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,[],'web');
        $response = $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    function test_admin_can_not_login_with_wrong_password()
    {
        $user = User::factory()->create();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->post(route('admin.login'), [
            'email' => $user->email,
            'password' => bcrypt("wrong_password")
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    function test_admin_can_not_login_without_password()
    {
        $user = User::factory()->create();
        $hasUser = $user ? true : false;
        $this->assertTrue($hasUser);
        $response = $this->post(route('admin.login'), [
            'email' => $user->email,
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }


    function test_authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::factory()->create([
            'firstname' => 'Test',
            'lastname' => 'testing',
            'email' => 'test@gmail.com',
            'phone' => '123456789',
            'password' => Hash::make('test123')
        ]),[] , 'web');
        $this->assertAuthenticated();
        $response = $this->post(route('admin.logout'));
        $response->assertRedirect();
        $this->assertGuest();
    }

}
