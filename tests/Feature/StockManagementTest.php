<?php

use App\Models\Food;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    function test_authenticated_user_can_create_stocks()
    {
        $food = Food::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('stocks.store'), [
            'quantity' => 350.0,
            'expiration_date' => '2022-11-22 11:20:30',
            'food_id' => $food->id
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('stocks', [
            'quantity' => 350.0,
            'expiration_date' => '2022-11-22 11:20:30',
            'food_id' => $food->id
        ]);
    }


    function test_guest_user_can_not_create_stocks()
    {
        $food = Food::factory()->create();

        $response = $this->post(route('stocks.store'), [
            'quantity' => 350.0,
            'expiration_date' => '2022-11-22 11:20:30',
            'food_id' => $food->id
        ]);

        $response->assertUnauthorized();
    }


    function test_authenticated_user_can_edit_stocks()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );
        $newFood = Food::factory()->create();

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('stocks.update', ['stock' => $stock]), [
            'quantity' => 350.0,
            'expiration_date' => '2022-11-22 11:20:30',
            'expired' => true,
            'food_id' => $newFood->id
        ]);

        $response->assertRedirect();
        $this->assertEquals(350.0, $stock->refresh()->quantity);
        $this->assertEquals('2022-11-22 11:20:30', $stock->refresh()->expiration_date);
        $this->assertEquals(true, $stock->refresh()->expired);
        $this->assertEquals($newFood->id, $stock->refresh()->food_id);
    }

    function test_guest_user_can_not_edit_stocks()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );
        $newFood = Food::factory()->create();

        $response = $this->post(route('stocks.update', ['stock' => $stock]), [
            'quantity' => 350.0,
            'expiration_date' => '2022-11-22 11:20:30',
            'food_id' => $newFood->id
        ]);

        $response->assertUnauthorized();
    }

    function test_authenticated_user_can_delete_stocks()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );

        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->post(route('stocks.destroy', ['stock' => $stock]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('stocks', [
            'id' => $stock->id
        ]);
    }

    function test_guest_user_can_not_delete_stocks()
    {
        $food = Food::factory()->create();
        $stock = Stock::factory()->create(
            ['food_id' => $food->id]
        );

        $response = $this->post(route('stocks.destroy', ['stock' => $stock]));

        $response->assertUnauthorized();
    }

}
