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

    function test_authenticated_user_can_create_food()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('food.store'), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('food', [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);
    }

    function test_guest_user_can_not_create_food()
    {
        $response = $this->post(route('food.store'), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_edit_food()
    {
        $food = Food::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('food.update', ['food' => $food]), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $response->assertRedirect(route('food.index'));
        $this->assertEquals('foo', $food->refresh()->name);
        $this->assertEquals('kg', $food->refresh()->units);
        $this->assertEquals('foo type', $food->refresh()->type);
    }

    function test_guest_user_can_not_edit_food()
    {
        $food = Food::factory()->create();

        $response = $this->put(route('food.update', ['food' => $food]), [
            'name' => 'foo',
            'units' => 'kg',
            'type' => 'foo type'
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_delete_food()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );
        $recipes = Recipe::factory()->count(2)->create();
        foreach ($recipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 450.50]);
        }
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('food.destroy', ['food' => $food]));

        $response->assertStatus(Response::HTTP_CONFLICT);

        $food->recipes()->detach();

        $response = $this->post(route('food.destroy', ['food' => $food]));

        $response->assertStatus(Response::HTTP_CONFLICT);

        $food->stocks()->delete();

        $response = $this->post(route('food.destroy', ['food' => $food]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('food', [
            'id' => $food->id
        ]);
    }

    function test_guest_user_can_not_delete_food()
    {
        $food = Food::factory()->create();

        $response = $this->delete(route('food.destroy', ['food' => $food]));

        $response->assertUnauthorized();
    }

}
