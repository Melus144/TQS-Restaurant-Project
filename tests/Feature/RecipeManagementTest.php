<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RecipeManagementTest extends TestCase
{
    use RefreshDatabase;

    function test_authenticated_user_can_create_recipes()
    {
        Storage::fake('public');

        Food::factory()->count(3)->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(route('api::v1::recipes.store'), [
            'name' => 'foo',
            'price' => 19.99,
            'type' => Recipe::TYPE_FIRST_COURSE,
            'food_type' => 1,
            'image' => UploadedFile::fake()->image('photo1.jpg'),
            'food' => [
                ['food_id' => 1, 'quantity' => 200],
                ['food_id' => 2, 'quantity' => 350.50],
                ['food_id' => 3, 'quantity' => 49.99]
            ]
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('recipes', [
            'name' => 'foo',
            'price' => 19.99,
            'type' => Recipe::TYPE_FIRST_COURSE,
            'food_type' => 1,
            'available' => true,
            'image' => 'images/recipes/1.jpg'
        ]);
        $this->assertDatabaseHas('food_recipe', [
            'food_id' => 1,
            'recipe_id' => 1,
            'quantity' => 200
        ]);
        $this->assertDatabaseHas('food_recipe', [
            'food_id' => 2,
            'recipe_id' => 1,
            'quantity' => 350.50
        ]);
        $this->assertDatabaseHas('food_recipe', [
            'food_id' => 3,
            'recipe_id' => 1,
            'quantity' => 49.99
        ]);
        Storage::disk('public')->assertExists('images/recipes/1.jpg');
    }

    function test_guest_user_can_not_create_recipes()
    {
        $response = $this->postJson(route('api::v1::recipes.store'), [
            'name' => 'foo',
            'price' => 19.99,
            'type' => Recipe::TYPE_FIRST_COURSE,
            'food_type' => 1,
            'available' => true,
            'image' => UploadedFile::fake()->image('photo1.jpg')
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_edit_recipes()
    {
        Storage::fake('public');
        UploadedFile::fake()->image('photo1.jpg')->storeAs('images/recipes', '1.jpg', 'public');

        Food::factory()->count(5)->create();
        $recipe = Recipe::factory()->create([
            'image' => 'images/recipes/1.jpg'
        ]);
        $recipe->food()->attach(2, ['quantity' => 450.50]);
        $recipe->food()->attach(3, ['quantity' => 250.50]);
        $recipe->food()->attach(4, ['quantity' => 430.50]);
        $recipe->food()->attach(5, ['quantity' => 20.99]);

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->putJson(route('api::v1::recipes.update', ['recipe' => $recipe]), [
            'name' => 'foo',
            'price' => 19.99,
            'type' => Recipe::TYPE_DESERT,
            'food_type' => 1,
            'available' => false,
            'image' => UploadedFile::fake()->image('photo1.png'),
            'food' => [
                ['food_id' => 1, 'quantity' => 200]
            ]
        ]);

        $response->assertNoContent();
        $this->assertEquals('foo', $recipe->refresh()->name);
        $this->assertEquals(19.99, $recipe->refresh()->price);
        $this->assertEquals(Recipe::TYPE_DESERT, $recipe->refresh()->type);
        $this->assertEquals(1, $recipe->refresh()->food_type);
        $this->assertEquals(false, $recipe->refresh()->available);
        $this->assertEquals('images/recipes/1.png', $recipe->refresh()->image);

        $foodIds = $recipe->refresh()->food->map(function ($food, $key) {
            return $food->id;
        });

        $this->assertTrue($foodIds->contains(1));
        $this->assertFalse($foodIds->contains(2));
        $this->assertFalse($foodIds->contains(3));
        $this->assertFalse($foodIds->contains(4));
        $this->assertFalse($foodIds->contains(5));

        Storage::disk('public')->assertMissing('images/recipes/1.jpg');
        Storage::disk('public')->assertExists('images/recipes/1.png');
    }

    function test_guest_user_can_not_edit_recipes()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->putJson(route('api::v1::recipes.update', ['recipe' => $recipe]), [
            'name' => 'foo',
            'price' => 19.99,
            'type' => Recipe::TYPE_DESERT,
            'food_type' => 1,
            'available' => false,
            'image' => UploadedFile::fake()->image('photo1.png'),
            'food' => [1]
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_delete_recipes()
    {
        Storage::fake('public');
        UploadedFile::fake()->image('photo1.jpg')->storeAs('images/recipes', '1.jpg', 'public');

        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $food = Food::factory()->create();
        $recipe = Recipe::factory()->create([
            'image' => 'images/recipes/1.jpg'
        ]);
        $recipe->food()->attach($food, ['quantity' => 450.50]);
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipe, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->deleteJson(route('api::v1::recipes.destroy', ['recipe' => $recipe]));

        $response->assertStatus(Response::HTTP_CONFLICT);

        $recipe->orders()->detach();

        $response = $this->deleteJson(route('api::v1::recipes.destroy', ['recipe' => $recipe]));

        $response->assertNoContent();
        $this->assertDatabaseMissing('recipes', [
            'id' => $recipe->id
        ]);
        $this->assertDatabaseMissing('food_recipe', [
            'recipe_id' => $recipe->id
        ]);
        Storage::disk('public')->assertMissing('images/recipes/1.jpg');
    }

    function test_guest_user_can_not_delete_recipes()
    {
        $food = Food::factory()->create();
        $recipe = Recipe::factory()->create([
            'image' => 'images/recipes/1.jpg'
        ]);
        $recipe->food()->attach($food, ['quantity' => 450.50]);

        $response = $this->deleteJson(route('api::v1::recipes.destroy', ['recipe' => $recipe]));

        $response->assertUnauthorized();
    }
}
