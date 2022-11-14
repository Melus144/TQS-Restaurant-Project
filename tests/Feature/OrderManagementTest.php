<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;


    function test_authenticated_user_can_create_orders()
    {
        $this->seed();

        $food = Food::factory()->create();

        $nonExpiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 350.50,
            'expiration_date' => \Carbon\Carbon::tomorrow()->timestamp,
            'expired' => false,
            'food_id' => $food->id
        ]);

        $expiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 200.50,
            'expiration_date' => \Carbon\Carbon::yesterday()->timestamp,
            'expired' => true,
            'food_id' => $food->id
        ]);

        $orderStatus = OrderStatus::waiting();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();
        foreach ($recipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(route('api::v1::orders.store'), [
            'booking_id' => $booking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => $recipes[0]->price * 2
                ],
                [
                    'recipe_id' => $recipes[1]->id,
                    'quantity' => 2,
                    'price' => $recipes[1]->price * 2
                ],
                [
                    'recipe_id' => $recipes[2]->id,
                    'quantity' => 1,
                    'price' => 5.49
                ],
            ]
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('orders', [
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $this->assertDatabaseHas('order_recipe', [
            'order_id' => 1,
            'recipe_id' => $recipes[0]->id,
            'quantity' => 2,
            'price' => $recipes[0]->price * 2
        ]);
        $this->assertDatabaseHas('order_recipe', [
            'order_id' => 1,
            'recipe_id' => $recipes[1]->id,
            'quantity' => 2,
            'price' => $recipes[1]->price * 2
        ]);
        $this->assertDatabaseHas('order_recipe', [
            'order_id' => 1,
            'recipe_id' => $recipes[2]->id,
            'quantity' => 1,
            'price' => 5.49
        ]);
    }

    function test_authenticated_user_can_not_create_orders_without_stock()
    {
        $this->seed();

        $orderStatus = OrderStatus::waiting();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(route('api::v1::orders.store'), [
            'booking_id' => $booking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => $recipes[0]->price * 2
                ],
                [
                    'recipe_id' => $recipes[1]->id,
                    'quantity' => 2,
                    'price' => $recipes[1]->price * 2
                ],
                [
                    'recipe_id' => $recipes[2]->id,
                    'quantity' => 1,
                    'price' => 5.49
                ],
            ]
        ]);

        $response->assertUnprocessable();
    }

    function test_guest_user_can_not_create_orders()
    {
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();

        $response = $this->postJson(route('api::v1::orders.store'), [
            'booking_id' => $booking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => $recipes[0]->price * 2
                ],
                [
                    'recipe_id' => $recipes[1]->id,
                    'quantity' => 2,
                    'price' => $recipes[1]->price * 2
                ],
                [
                    'recipe_id' => $recipes[2]->id,
                    'quantity' => 1,
                    'price' => 5.49
                ],
            ]
        ]);

        $response->assertUnauthorized();
    }


    function test_authenticated_user_can_edit_orders_without_order_status_id()
    {
        $food = Food::factory()->create();

        $nonExpiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 350.50,
            'expiration_date' => \Carbon\Carbon::tomorrow()->timestamp,
            'expired' => false,
            'food_id' => $food->id
        ]);

        $expiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 200.50,
            'expiration_date' => \Carbon\Carbon::yesterday()->timestamp,
            'expired' => true,
            'food_id' => $food->id
        ]);

        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();
        foreach ($recipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        $newBooking = Booking::factory()->create();
        $newRecipes = Recipe::factory()->count(2)->create();
        foreach ($newRecipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->putJson(route('api::v1::orders.update', ['order' => $order]), [
            'booking_id' => $newBooking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => 38.98
                ],
                [
                    'recipe_id' => $newRecipes[0]->id,
                    'quantity' => 2,
                    'price' => 25.55
                ],
                [
                    'recipe_id' => $newRecipes[1]->id,
                    'quantity' => 1,
                    'price' => 9.50
                ]

            ]
        ]);

        $response->assertNoContent();

        $this->assertEquals($orderStatus->id, $order->refresh()->order_status_id);
        $this->assertEquals($newBooking->id, $order->refresh()->booking_id);

        $recipeIds = $order->refresh()->recipes->map(function ($recipe, $key) {
            return $recipe->id;
        });

        $this->assertFalse($recipeIds->contains($recipes[1]->id));
        $this->assertTrue($recipeIds->contains($recipes[0]->id));
        $this->assertTrue($recipeIds->contains($newRecipes[0]->id));
        $this->assertTrue($recipeIds->contains($newRecipes[1]->id));
    }

    function test_authenticated_user_can_edit_orders_with_order_status_id()
    {
        $food = Food::factory()->create();

        $nonExpiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 350.50,
            'expiration_date' => \Carbon\Carbon::tomorrow()->timestamp,
            'expired' => false,
            'food_id' => $food->id
        ]);

        $expiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 200.50,
            'expiration_date' => \Carbon\Carbon::yesterday()->timestamp,
            'expired' => true,
            'food_id' => $food->id
        ]);

        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();
        foreach ($recipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        $newOrderStatus = OrderStatus::factory()->create();
        $newBooking = Booking::factory()->create();
        $newRecipes = Recipe::factory()->count(2)->create();
        foreach ($newRecipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->putJson(route('api::v1::orders.update', ['order' => $order]), [
            'order_status_id' => $newOrderStatus->id,
            'booking_id' => $newBooking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => 38.98
                ],
                [
                    'recipe_id' => $newRecipes[0]->id,
                    'quantity' => 2,
                    'price' => 25.55
                ],
                [
                    'recipe_id' => $newRecipes[1]->id,
                    'quantity' => 1,
                    'price' => 9.50
                ]

            ]
        ]);

        $response->assertNoContent();

        $this->assertEquals($newOrderStatus->id, $order->refresh()->order_status_id);
        $this->assertEquals($newBooking->id, $order->refresh()->booking_id);

        $recipeIds = $order->refresh()->recipes->map(function ($recipe, $key) {
            return $recipe->id;
        });

        $this->assertFalse($recipeIds->contains($recipes[1]->id));
        $this->assertTrue($recipeIds->contains($recipes[0]->id));
        $this->assertTrue($recipeIds->contains($newRecipes[0]->id));
        $this->assertTrue($recipeIds->contains($newRecipes[1]->id));
    }

    function test_authenticated_user_can_not_edit_orders_with_recipes_without_stock()
    {
        $food = Food::factory()->create();

        $nonExpiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 350.50,
            'expiration_date' => \Carbon\Carbon::tomorrow()->timestamp,
            'expired' => false,
            'food_id' => $food->id
        ]);

        $expiredStocks = Stock::factory()->count(2)->create([
            'quantity' => 200.50,
            'expiration_date' => \Carbon\Carbon::yesterday()->timestamp,
            'expired' => true,
            'food_id' => $food->id
        ]);

        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(3)->create();
        foreach ($recipes as $recipe) {
            $recipe->food()->attach($food, ['quantity' => 20]);
        }
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        $newOrderStatus = OrderStatus::factory()->create();
        $newBooking = Booking::factory()->create();
        $newRecipes = Recipe::factory()->count(2)->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->putJson(route('api::v1::orders.update', ['order' => $order]), [
            'order_status_id' => $newOrderStatus->id,
            'booking_id' => $newBooking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => 38.98
                ],
                [
                    'recipe_id' => $newRecipes[0]->id,
                    'quantity' => 2,
                    'price' => 25.55
                ],
                [
                    'recipe_id' => $newRecipes[1]->id,
                    'quantity' => 1,
                    'price' => 9.50
                ]

            ]
        ]);

        $response->assertUnprocessable();
    }

    function test_guest_user_can_not_edit_recipes()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(2)->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        $newBooking = Booking::factory()->create();
        $newRecipes = Recipe::factory()->count(2)->create();

        $response = $this->putJson(route('api::v1::orders.update', ['order' => $order]), [
            'booking_id' => $newBooking->id,
            'recipes' => [
                [
                    'recipe_id' => $recipes[0]->id,
                    'quantity' => 2,
                    'price' => 38.98
                ],
                [
                    'recipe_id' => $newRecipes[0]->id,
                    'quantity' => 2,
                    'price' => 25.55
                ],
                [
                    'recipe_id' => $newRecipes[1]->id,
                    'quantity' => 1,
                    'price' => 9.50
                ]

            ]
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_delete_orders()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(2)->create();
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

        $response = $this->deleteJson(route('api::v1::orders.destroy', ['order' => $order]));

        $response->assertNoContent();
        $this->assertDatabaseMissing('orders', [
            'id' => $order->id
        ]);
        $this->assertDatabaseMissing('order_recipe', [
            'order_id' => $order->id
        ]);
    }

    function test_guest_user_can_not_delete_orders()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(2)->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        $response = $this->deleteJson(route('api::v1::orders.destroy', ['order' => $order]));

        $response->assertUnauthorized();
    }

}