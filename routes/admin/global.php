<?php

use App\Admin\Food\Controllers\FoodController;
use App\Admin\Orders\Controllers\OrderController;
use App\Admin\Users\Controllers\UsersController;
use App\DatatableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class, 'index'])->name('home');

Route::get('/users/list', [DatatableController::class, 'listUsers'])->name('datatable.users');
// RESOURCES
Route::resource('users', UsersController::class)->except('show');
Route::resource('food', FoodController::class)->except('show');

Route::get('/refbd', [OrderController::class, 'seed_bd'])->name('seed_bd');

