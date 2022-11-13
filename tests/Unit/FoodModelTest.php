<?php

namespace Tests\Unit;

use App\Models\Food;
use App\Models\Recipe;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FoodModelTest extends TestCase
{
    use RefreshDatabase;

    function test_food_has_name_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('food', [
                'name'
            ]), true
        );
    }

    function test_food_has_units_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('food', [
                'units'
            ]), true
        );
    }

    function test_food_has_type_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('food', [
                'type'
            ]), true
        );
    }

    function test_food_has_stock_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('food', [
                'stock'
            ]), true
        );
    }

    public function test_food_has_many_stocks()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );

        $this->assertTrue($food->stocks->contains($stock));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $food->stocks);
    }

    public function test_food_belongs_to_many_recipes()
    {
        $food = Food::factory()->count(3)->create();
        $recipe = Recipe::factory()->create();
        $recipe->food()->attach($food, ['quantity' => 450.50]);

        foreach ($food as $singleFood) {
            $this->assertTrue($recipe->food->contains($singleFood));
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $singleFood->recipes);
        }
    }
}
