<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('inicio');

Route::get('/contacto', function () {
    return view('contact');
})->name('contacto');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('carrito', [CartController::class, 'cartList'])->name('carrito');
Route::post('carrito', [CartController::class, 'addToCart'])->name('añadirCarrito');
Route::post('actualizar-carrito', [CartController::class, 'updateCart'])->name('actualizarCarrito');
Route::post('remove', [CartController::class, 'removeCart'])->name('eliminarCarrito');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('vaciarCarrito');

Route::post('/pedido-realizado', [OrderController::class, 'store'])->name('pedido-realizado');
