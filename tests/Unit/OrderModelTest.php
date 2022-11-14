<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_belongs_to_a_order_status()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);

        $this->assertInstanceOf(OrderStatus::class, $order->orderStatus);
    }

    public function test_orders_belongs_to_a_booking()
    {
        $booking = Booking::factory()->create();
        $orderStatus = OrderStatus::factory()->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);

        $this->assertInstanceOf(Booking::class, $order->booking);
    }

    public function test_order_belongs_to_many_recipes()
    {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $orders = Order::factory()->count(3)->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);
        $recipe = Recipe::factory()->create();
        $recipe->orders()->attach($orders, [
            'quantity' => 1,
            'price' => 19.99
        ]);

        foreach ($orders as $order) {
            $this->assertTrue($recipe->orders->contains($order));
            $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $order->recipes);
        }
    }
}
