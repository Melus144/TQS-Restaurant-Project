<?php

use App\Models\Food;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StockModelTest extends TestCase
{
    use RefreshDatabase;

    function test_stocks_has_quantity_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('stocks', [
                'quantity'
            ]), true
        );
    }

    function test_stocks_has_expiration_date_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('stocks', [
                'expiration_date'
            ]), true
        );
    }

    function test_stocks_has_expired_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('stocks', [
                'expired'
            ]), true
        );
    }

    function test_stocks_has_food_id_attribute()
    {
        $this->assertTrue(
            Schema::hasColumns('stocks', [
                'food_id'
            ]), true
        );
    }

    public function test_stocks_belongs_to_a_food()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );

        $this->assertInstanceOf(Food::class, $stock->food);
    }
}
