<?php

use App\Admin\Orders\Requests\OrderRequest;
use App\Models\Booking;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFeaturesTest extends TestCase
{
    use RefreshDatabase;

    //Loop Testing : calcular subtotal: 2 foreach por cada plato i luego cada cantidad de plato
    public function test_cart_total() {
        $orderStatus = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $order = Order::factory()->create([
            'order_status_id' => $orderStatus->id,
            'booking_id' => $booking->id
        ]);

        $recipes_first_course = Recipe::factory()->count(3)->create([
            'price' => 10.50,
            'type' => Recipe::TYPE_FIRST_COURSE,
        ]);
        $recipes_main_course = Recipe::factory()->count(5)->create([
            'price' => 20.2,
            'type' => Recipe::TYPE_MAIN_COURSE,
        ]);

        $all_recipes = array_merge($recipes_first_course->toArray(), $recipes_main_course->toArray());

        $preu_first_course = 0;
        $preu_main_course = 0;
        foreach ($all_recipes as $recipe) {
            if($recipe['type'] == Recipe::TYPE_FIRST_COURSE) {
                $preu_first_course += $recipe['price'];
            } else {
                $preu_main_course += $recipe['price'];
            }
            $order_price += $recipe['price'];

        }
        $this->assertEquals(31.5, $preu_first_course->sum('price'));
        $this->assertEquals(101.0, $preu_main_course->sum('price'));

    }

    //COndition,Decision,Path coverage: Booking id correcto, Order status id correcto, min 1 recipe,
    public function test_guest_can_order() {

        //Condition Coverage: Booking id incorrecto
        $order_status = OrderStatus::factory()->create();
        $booking = Booking::factory()->create();
        $recipes = Recipe::factory()->count(2)->create();
        //$recipe = Recipe::factory()->count(2)->create();
        //Condition Coverage: Booking id correcto, order status <0 no correcto

        //Condition Coverage: Booking id correcto, order status >25 no correcto


        //Condition Coverage: 3 condiciones true
        //Decision coverage: TOT OK (booking, order status id >0, <25


        //Condition coverage: 3 condiciones false
        //Decision coverage: Decisio 2 if false.

    }

    //This function can be tested in condition, decision, path coverage
    public function test_comanda_valida($order_status_id, $booking_id, $recipes) {
        if($order_status_id > 0 && $order_status_id < 25) {
            $booking = Booking::where('id', $booking_id)->first();
            if ($booking) {
                if (count($recipes) > 0) {
                    return true;
                }
            }
        }
    return false;
    }

}
