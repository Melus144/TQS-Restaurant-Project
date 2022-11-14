<?php

use App\Models\Booking;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RecipeModelTest extends TestCase
{
    use RefreshDatabase;

    function test_recipes_has_name_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'name'
            ]), true
        );
    }

    function test_recipes_has_price_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'price'
            ]), true
        );
    }

    function test_recipes_has_type_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'type'
            ]), true
        );
    }

    function test_recipes_has_available_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'available'
            ]), true
        );
    }

    function test_recipes_has_image_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'image'
            ]), true
        );
    }

    function test_recipes_has_food_type_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('recipes', [
                'food_type'
            ]), true
        );
    }

    public function test_recipe_belongs_to_many_food()
    {
        $recipes = Recipe::factory()->count(3)->create();
        $food = Food::factory()->create();
        $food->recipes()->attach($recipes, ['quantity' => 450.50]);

        foreach ($recipes as $recipe) {
            $this->assertTrue($food->recipes->contains($recipe));
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $recipe->food);
        }
    }

    public function test_recipe_belongs_to_many_orders()
    {
        $recipes = Recipe::factory()->count(3)->create();
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $order->recipes()->attach($recipes, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        foreach ($recipes as $recipe) {
            $this->assertTrue($order->recipes->contains($recipe));
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $recipe->orders);
        }
    }
}
