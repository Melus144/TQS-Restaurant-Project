<?php

use App\DatatableController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/users/list', [DatatableController::class, 'listUsers'])->name('datatable.users');

});
