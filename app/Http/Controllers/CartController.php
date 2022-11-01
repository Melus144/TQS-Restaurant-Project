<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        //dd($cartItems);
        return view('order', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'quantity' => $request->quantity,
        ]);
        session()->flash('success', 'El producto se ha añadido al carrito');
        $cartItems = \Cart::getContent();

        return redirect()->route('menu', compact('cartItems'));
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'La cantidad del producto ha sido actualizada');

        return redirect()->route('carrito');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'El producto se ha eliminado del carrito');

        return redirect()->route('carrito');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'Todos los elementos del carrito se han eliminado correctamente');

        return redirect()->route('carrito');
    }
}
