<?php

use App\Http\Controllers\Api\V1\AiController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\FoodController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\StockController;
use App\Http\Controllers\Api\V1\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api::v1::')->middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::get('/food', [FoodController::class, 'index'])->name('food.index');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');
    Route::get('/food/{food}', [FoodController::class, 'show'])->name('food.show');
    Route::put('/food/{food}', [FoodController::class, 'update'])->name('food.update');
    Route::delete('/food/{food}', [FoodController::class, 'destroy'])->name('food.destroy');
    Route::get('/food/{food}/stocks', [FoodController::class, 'stocks'])->name('food.stocks');

    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');
    Route::get('/stocks/{stock}', [StockController::class, 'show'])->name('stocks.show');
    Route::put('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');
    Route::delete('/stocks/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy');
    Route::get('/stocks/expiration/expired', [StockController::class, 'expired'])->name('stocks.expired');
    Route::get('/stocks/expiration/non-expired', [StockController::class, 'nonExpired'])->name('stocks.nonExpired');

    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('/orders/status/waiting', [OrderController::class, 'waiting'])->name('orders.waiting');
    Route::get('/orders/status/confirmed', [OrderController::class, 'confirmed'])->name('orders.confirmed');
    Route::get('/orders/status/cancelled', [OrderController::class, 'cancelled'])->name('orders.cancelled');
    Route::get('/orders/status/in-process', [OrderController::class, 'inProcess'])->name('orders.in-process');
    Route::get('/orders/status/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
    Route::get('/orders/status/paid', [OrderController::class, 'paid'])->name('orders.paid');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

Route::get('/ai/data', [AiController::class, 'getData'])->name('ai.data');
Route::post('/ai/predictions', [AiController::class, 'getPredictions'])->name('ai.predictions');
Route::get('/ai/retrain-customers', [AiController::class, 'retrainCustomers'])->name('ai.retrain-customers');
Route::get('/ai/retrain-food', [AiController::class, 'retrainFood'])->name('ai.retrain-food');
