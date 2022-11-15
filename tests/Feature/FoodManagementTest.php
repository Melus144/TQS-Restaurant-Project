<?php

use App\Models\Booking;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FoodManagementTest extends TestCase
{
    use RefreshDatabase;


    function test_guest_user_can_not_create_food()
    {
        $response = $this->post(route('admin.food.store'), [
            'name' => 'foo2',
            'units' => 'kg2',
            'type' => 'foo type2'
        ]);
        $response->assertRedirect(route('admin.login'));
        $this->assertDatabaseMissing('food', [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

    }

    function test_guest_user_can_not_edit_food()
    {
        $food = Food::factory()->create();

        $response = $this->post(route('admin.food.update', ['food' => $food]), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $response->assertStatus(405);
    }

    function test_guest_user_can_not_delete_food()
    {
        $food = Food::factory()->create();

        $response = $this->post(route('admin.food.destroy', ['food' => $food]));

        $response->assertStatus(405);
    }

    function test_authenticated_user_can_create_food()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('admin.food.store'), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $this->assertDatabaseHas('food', [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);
    }



}
