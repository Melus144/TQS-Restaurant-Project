<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api::fake::')->group(function () {
    // List of foods
    Route::get('/food', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'food',
                    'id' => 1,
                    'attributes' => [
                        'name' => 'foo 1',
                        'units' => 'kg',
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ],
                [
                    'type' => 'food',
                    'id' => 2,
                    'attributes' => [
                        'name' => 'foo 2',
                        'units' => 'l',
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('food.index');

    // Create food
    Route::post('/food', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    })->name('food.store');

    // Get single food
    Route::get('/food/{food}', function (Request $request) {
        return response()->json([
            'data' => [
                'type' => 'food',
                'id' => 1,
                'attributes' => [
                    'name' => 'foo 1',
                    'units' => 'kg',
                    'created_at' => '2012/03/06 17:33:07',
                    'updated_at' => '2012/03/06 17:33:07'
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('food.show');

    // Modify food
    Route::put('/food/{food}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('food.update');

    // Remove food
    Route::delete('/food/{food}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('food.destroy');

    // List of stocks of food
    Route::get('/food/{food}/stocks', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'stocks',
                    'id' => 1,
                    'attributes' => [
                        'quantity' => 22,
                        'expiration_date' => '2023/05/06 00:00:00',
                        'expired' => false,
                        'food_id' => 1,
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ]);
    })->name('food.stocks');

    // List of stocks
    Route::get('/stocks', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'stocks',
                    'id' => 1,
                    'attributes' => [
                        'quantity' => 22,
                        'expiration_date' => '2023/05/06 00:00:00',
                        'expired' => false,
                        'food_id' => 1,
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ],
                [
                    'type' => 'stocks',
                    'id' => 2,
                    'attributes' => [
                        'quantity' => 33,
                        'expiration_date' => '2023/05/06 00:00:00',
                        'expired' => false,
                        'food_id' => 2,
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ],\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('stocks.index');

    // Create stock
    Route::post('/stocks', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    })->name('stocks.store');

    // Get single stock
    Route::get('/stocks/{stock}', function (Request $request) {
        return response()->json([
            'data' => [
                'type' => 'stocks',
                'id' => 1,
                'attributes' => [
                    'quantity' => 22,
                    'expiration_date' => '2023/05/06 00:00:00',
                    'expired' => false,
                    'food_id' => 1,
                    'created_at' => '2012/03/06 17:33:07',
                    'updated_at' => '2012/03/06 17:33:07'
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('stocks.show');

    // Modify stock
    Route::put('/stocks/{stock}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('stocks.update');

    // Remove food story
    Route::delete('/stocks/{stock}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('stocks.destroy');

    // List of recipes
    Route::get('/recipes', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'recipes',
                    'id' => 1,
                    'attributes' => [
                        'name' => 'foo 1',
                        'price' => '10.99',
                        'available' => true,
                        'image' => '/img/image.png',
                        'food' => [
                            [
                                'type' => 'food',
                                'id' => 1,
                                'attributes' => [
                                    'name' => 'foo 1',
                                    'units' => 'kg',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            [
                                'type' => 'food',
                                'id' => 2,
                                'attributes' => [
                                    'name' => 'foo 2',
                                    'units' => 'l',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ]
                        ],
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ],
                [
                    'type' => 'recipes',
                    'id' => 2,
                    'attributes' => [
                        'name' => 'foo 2',
                        'price' => '15.99',
                        'available' => true,
                        'image' => '/img/image.png',
                        'food' => [
                            [
                                'type' => 'food',
                                'id' => 1,
                                'attributes' => [
                                    'name' => 'foo 1',
                                    'units' => 'kg',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            [
                                'type' => 'food',
                                'id' => 2,
                                'attributes' => [
                                    'name' => 'foo 2',
                                    'units' => 'l',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ]
                        ],
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('recipes.index');

    // Create recipe
    Route::post('/recipes', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    })->name('recipes.store');

    // Get single recipe
    Route::get('/recipes/{recipe}', function (Request $request) {
        return response()->json([
            'data' => [
                'type' => 'recipes',
                'id' => 1,
                'attributes' => [
                    'name' => 'foo 1',
                    'price' => '10.99',
                    'available' => true,
                    'image' => '/img/image.png',
                    'food' => [
                        [
                            'type' => 'food',
                            'id' => 1,
                            'attributes' => [
                                'name' => 'foo 1',
                                'units' => 'kg',
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        [
                            'type' => 'food',
                            'id' => 2,
                            'attributes' => [
                                'name' => 'foo 2',
                                'units' => 'l',
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ]
                    ],
                    'created_at' => '2012/03/06 17:33:07',
                    'updated_at' => '2012/03/06 17:33:07'
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('recipes.show');

    // Modify recipe
    Route::put('/recipes/{recipe}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('recipes.update');

    // Remove recipe
    Route::delete('/recipes/{recipe}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('recipes.destroy');

    // List of orders
    Route::get('/orders', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'orders',
                    'id' => 1,
                    'attributes' => [
                        'order_status_id' => 11,
                        'booking_id' => 22,
                        'status' => [
                            'type' => 'statuses',
                            'id' => 1,
                            'attributes' => [
                                'status' => 'Completada',
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'booking' => [
                            'type' => 'bookings',
                            'id' => 1,
                            'attributes' => [
                                'name' => 'foo booking',
                                'email' => 'foo@foo.com',
                                'phone' => '+34 111 111 111',
                                'date' => '2022/04/13 21:30:00',
                                'people' => 6,
                                'table' => 'foo'
                            ]
                        ],
                        'recipes' => [
                            [
                                'order_id' => 1,
                                'recipe_id' => 1,
                                'quantity' => 3,
                                'price' => 30.55,
                                'type' => 1,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ],
                            [
                                'order_id' => 1,
                                'recipe_id' => 2,
                                'quantity' => 3,
                                'price' => 28.99,
                                'type' => 2,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ],
                [
                    'type' => 'orders',
                    'id' => 2,
                    'attributes' => [
                        'order_status_id' => 10,
                        'booking_id' => 22,
                        'status' => [
                            'type' => 'statuses',
                            'id' => 1,
                            'attributes' => [
                                'status' => 'Confirmada',
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'booking' => [
                            'type' => 'bookings',
                            'id' => 2,
                            'attributes' => [
                                'name' => 'foo booking',
                                'email' => 'foo@foo.com',
                                'phone' => '+34 111 111 111',
                                'date' => '2022/04/13 22:30:00',
                                'people' => 5,
                                'table' => 'foo'
                            ]
                        ],
                        'recipes' => [
                            [
                                'order_id' => 2,
                                'recipe_id' => 1,
                                'quantity' => 1,
                                'price' => 15.50,
                                'type' => 1,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ],
                            [
                                'order_id' => 2,
                                'recipe_id' => 2,
                                'quantity' => 2,
                                'price' => 25.95,
                                'type' => 2,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('orders.index');

    // Create order
    Route::post('/orders', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    })->name('orders.store');

    // Get single order
    Route::get('/orders/{order}', function (Request $request) {
        return response()->json([
            'data' => [
                'type' => 'orders',
                'id' => 1,
                'attributes' => [
                    'order_status_id' => 11,
                    'booking_id' => 22,
                    'status' => [
                        'type' => 'statuses',
                        'id' => 1,
                        'attributes' => [
                            'status' => 'Completada',
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ],
                    'booking' => [
                        'type' => 'bookings',
                        'id' => 1,
                        'attributes' => [
                            'name' => 'foo booking',
                            'email' => 'foo@foo.com',
                            'phone' => '+34 111 111 111',
                            'date' => '2022/04/13 21:30:00',
                            'people' => 6,
                            'table' => 'foo'
                        ]
                    ],
                    'recipes' => [
                        [
                            'order_id' => 1,
                            'recipe_id' => 1,
                            'quantity' => 3,
                            'price' => 30.55,
                            'type' => 1,
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ],
                        [
                            'order_id' => 1,
                            'recipe_id' => 2,
                            'quantity' => 3,
                            'price' => 28.99,
                            'type' => 2,
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ],
                    'created_at' => '2012/03/06 17:33:07',
                    'updated_at' => '2012/03/06 17:33:07'
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('orders.show');

    // Modify order
    Route::put('/orders/{order}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('orders.update');

    // Remove order
    Route::delete('/orders/{order}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('orders.destroy');

    // List of bookings
    Route::get('/booking', function (Request $request) {
        return response()->json([
            'data' => [
                [
                    'type' => 'booking',
                    'id' => 1,
                    'attributes' => [
                        'name' => 'foo 1',
                        'email' => 'mail@mail.com',
                        'phone' => '+34 111 111 111',
                        'date' => '2012/03/06 17:33:07',
                        'people' => '3',
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ],
                    'orders' => [
                        'type' => 'orders',
                        'id' => 1,
                        'attributes' => [
                            'order_status_id' => 11,
                            'booking_id' => 22,
                            'status' => [
                                'type' => 'statuses',
                                'id' => 1,
                                'attributes' => [
                                    'status' => 'Completada',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            'booking' => [
                                'type' => 'bookings',
                                'id' => 1,
                                'attributes' => [
                                    'name' => 'foo booking',
                                    'email' => 'foo@foo.com',
                                    'phone' => '+34 111 111 111',
                                    'date' => '2022/04/13 21:30:00',
                                    'people' => 6,
                                    'table' => 'foo'
                                ]
                            ],
                            'recipes' => [
                                [
                                    'order_id' => 1,
                                    'recipe_id' => 1,
                                    'quantity' => 3,
                                    'price' => 30.55,
                                    'type' => 1,
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ],
                                [
                                    'order_id' => 1,
                                    'recipe_id' => 2,
                                    'quantity' => 3,
                                    'price' => 28.99,
                                    'type' => 2,
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ],
                    'bills' => [
                        'type' => 'bill',
                        'id' => 1,
                        'attributes' => [
                            'amount' => 45,
                            'booking_id' => 1,
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ]
                ],
                [
                    'type' => 'booking',
                    'id' => 2,
                    'attributes' => [
                        'name' => 'foo 1',
                        'email' => 'mail2@mail.com',
                        'phone' => '+34 222 222 222',
                        'date' => '2012/03/06 17:33:07',
                        'people' => '3',
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ],
                    'orders' => [
                        'type' => 'orders',
                        'id' => 1,
                        'attributes' => [
                            'order_status_id' => 11,
                            'booking_id' => 22,
                            'status' => [
                                'type' => 'statuses',
                                'id' => 1,
                                'attributes' => [
                                    'status' => 'Completada',
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            'booking' => [
                                'type' => 'bookings',
                                'id' => 1,
                                'attributes' => [
                                    'name' => 'foo booking',
                                    'email' => 'foo@foo.com',
                                    'phone' => '+34 111 111 111',
                                    'date' => '2022/04/13 21:30:00',
                                    'people' => 6,
                                    'table' => 'foo'
                                ]
                            ],
                            'recipes' => [
                                [
                                    'order_id' => 1,
                                    'recipe_id' => 1,
                                    'quantity' => 3,
                                    'price' => 30.55,
                                    'type' => 1,
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ],
                                [
                                    'order_id' => 1,
                                    'recipe_id' => 2,
                                    'quantity' => 3,
                                    'price' => 28.99,
                                    'type' => 2,
                                    'created_at' => '2012/03/06 17:33:07',
                                    'updated_at' => '2012/03/06 17:33:07'
                                ]
                            ],
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ],
                    'bills' => [
                        'type' => 'bill',
                        'id' => 2,
                        'attributes' => [
                            'amount' => 50,
                            'booking_id' => 2,
                            'created_at' => '2012/03/06 17:33:07',
                            'updated_at' => '2012/03/06 17:33:07'
                        ]
                    ]
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('booking.index');

    // Create booking
    Route::post('/bookings', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
    })->name('bookings.store');

    // Get single booking
    Route::get('/recipes/{recipe}', function (Request $request) {
        return response()->json([
            'data' => [
                'type' => 'booking',
                'id' => 1,
                'attributes' => [
                    'name' => 'foo 1',
                    'email' => 'mail@mail.com',
                    'phone' => '+34 111 111 111',
                    'date' => '2012/03/06 17:33:07',
                    'people' => '3',
                    'created_at' => '2012/03/06 17:33:07',
                    'updated_at' => '2012/03/06 17:33:07'
                ],
                'orders' => [
                    'type' => 'orders',
                    'id' => 1,
                    'attributes' => [
                        'order_status_id' => 11,
                        'booking_id' => 22,
                        'status' => [
                            'type' => 'statuses',
                            'id' => 1,
                            'attributes' => [
                                'status' => 'Completada',
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'booking' => [
                            'type' => 'bookings',
                            'id' => 1,
                            'attributes' => [
                                'name' => 'foo booking',
                                'email' => 'foo@foo.com',
                                'phone' => '+34 111 111 111',
                                'date' => '2022/04/13 21:30:00',
                                'people' => 6,
                                'table' => 'foo'
                            ]
                        ],
                        'recipes' => [
                            [
                                'order_id' => 1,
                                'recipe_id' => 1,
                                'quantity' => 3,
                                'price' => 30.55,
                                'type' => 1,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ],
                            [
                                'order_id' => 1,
                                'recipe_id' => 2,
                                'quantity' => 3,
                                'price' => 28.99,
                                'type' => 2,
                                'created_at' => '2012/03/06 17:33:07',
                                'updated_at' => '2012/03/06 17:33:07'
                            ]
                        ],
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ],
                'bills' => [
                    'type' => 'bill',
                    'id' => 1,
                    'attributes' => [
                        'amount' => 45,
                        'booking_id' => 1,
                        'created_at' => '2012/03/06 17:33:07',
                        'updated_at' => '2012/03/06 17:33:07'
                    ]
                ]
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    })->name('recipes.show');

    // Remove booking
    Route::delete('/bookings/{bookings}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('bookings.destroy');

    // Modify booking
    Route::put('/bookings/{bookings}', function (Request $request) {
        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    })->name('bookings.update');

});
