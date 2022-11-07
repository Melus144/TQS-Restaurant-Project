<?php
Route::get('/', [OrderController::class, 'index'])->name('home');

Route::get('sites', [SitesController::class, 'index'])->name('sites.index');
Route::get('sites/create', [SitesController::class, 'create'])->name('sites.create');
Route::get('sites/{site}', [SitesController::class, 'edit'])->name('sites.edit');
Route::patch('sites/{site}', [SitesController::class, 'update'])->name('sites.update');
Route::post('sites/store', [SitesController::class, 'store'])->name('sites.store');

Route::resource('categories', CategoryController::class)->except('show');

Route::get('landings/update', [LandingController::class])->name('landings.update');

Route::get('/order-lines/{order}', [OrderController::class, 'orderLines'])->name('order-lines.show');
Route::get('/order-lines/{order}/invoice', [OrderController::class, 'invoice'])->name('order-lines.invoice');

Route::get('/redsys', [RedsysController::class, 'index'])->name('redsys.index');

Route::get('all-products', [PackController::class, 'getAllProducts'])->name('packs.product.all');

// RESOURCES
Route::resource('users', UsersController::class)->except('show');

