<?php

use App\DatatableController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/users/list', [DatatableController::class, 'listUsers'])->name('datatable.users');
    Route::get('/food/list', [DatatableController::class, 'listFood'])->name('datatable.food');
    Route::get('/recipes/list', [DatatableController::class, 'listRecipes'])->name('datatable.recipes');
    Route::get('/stock/list', [DatatableController::class, 'listRecipes'])->name('datatable.stock');

});
