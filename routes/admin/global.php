<?php

use App\Admin\Users\Controllers\UsersController;
use App\DatatableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class, 'index'])->name('home');

Route::get('/users/list', [DatatableController::class, 'listUsers'])->name('datatable.users');
//Route::post('/users/create', [UsersController::class, 'store'])->name('users.store ');
// RESOURCES
Route::resource('users', UsersController::class)->except('show');




//Route::get('/', [OrderController::class, 'index'])->name('home');
//Route::resource('categories', CategoryController::class)->except('show');

//Route::get('all-products', [PackController::class, 'getAllProducts'])->name('packs.product.all');

//Route::get('/order-lines/{order}', [OrderController::class, 'orderLines'])->name('order-lines.show');
//Route::get('/order-lines/{order}/invoice', [OrderController::class, 'invoice'])->name('order-lines.invoice');

