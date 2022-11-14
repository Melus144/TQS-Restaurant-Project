<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Admin\Food\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|max:8',
        ]);

        $cartItems = \Cart::getContent();

        //order status = 0 - waiting
        $order = Order::create([
            'order_status_id' => 0,
            'booking_id' => $request->booking_id
        ]);

        foreach ($cartItems as $recipe) {
            $order->recipes()->attach($recipe->id, [
                'quantity' => $recipe->quantity,
                'price' => $recipe->price
            ]);
        }
        \Cart::clear();
        return view('order-completed');
    }
}
