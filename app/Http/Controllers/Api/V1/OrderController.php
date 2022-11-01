<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Recipe;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Orders
 *
 * Endpoints for orders management
 */
class OrderController extends Controller
{
    /**
     * Get all orders
     *
     * Retrieve all orders from database
     *
     * Returns 200 OK if database contains any order.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "En espera", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Confirmada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::all();

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create an order.
     *
     * Endpoint for creating an order.
     *
     * Returns 201 CREATED when created.
     *
     * Returns 422 UNPROCESSABLE_ENTITY if any recipe can not be prepared due to lack of stock.
     * @param OrderRequest $request
     * @bodyParam order_status_id string
     * @bodyParam booking_id string required
     * @bodyParam recipes object[] Array of recipes.
     * @return \Illuminate\Http\JsonResponse
     * @response 422 [ {"errors": {"stock": ["Insufficient stock."]}} ]
     *
     */
    public function store(OrderRequest $request): \Illuminate\Http\JsonResponse
    {
        foreach ($request->recipes as $recipe) {
            $recipe = Recipe::find($recipe['recipe_id']);
            if (!$recipe->hasStock()) {
                return response()->json([
                    'errors' => ['stock' => ['Insufficient stock.']]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $order = Order::create([
            'order_status_id' => 0,
            'booking_id' => $request->booking_id
        ]);

        foreach ($request->recipes as $recipe) {
            $order->recipes()->attach($recipe['recipe_id'], [
                'quantity' => $recipe['quantity'],
                'price' => $recipe['price']
            ]);
        }

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Get a single order
     *
     * User retrieves a single order from database.
     *
     * Returns 200 OK if order exists.
     *
     * @urlParam order integer required Order ID.
     *
     * @response 200 scenario="Order exists" {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Completada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera","quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}
     */
    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return OrderResource::make($order)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update an order
     *
     * Endopoint for updating an order.
     *
     * Returns 204 NO_CONTENT when updated.
     *
     * Returns 422 UNPROCESSABLE_ENTITY if any order's recipe has no stock.
     *
     *
     * @urlParam order integer required Order ID.
     * @bodyParam recipes object[] Array of recipes
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @response 422 [ {"errors": {"stock": ["Insufficient stock."]}} ]
     */
    public function update(OrderRequest $request, Order $order): \Illuminate\Http\JsonResponse
    {
        foreach ($request->recipes as $recipe) {
            $recipe = Recipe::find($recipe['recipe_id']);
            if (!$recipe->hasStock()) {
                return response()->json([
                    'errors' => ['stock' => ['Insufficient stock.']]
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $order->update($request->safe()->only(['booking_id', 'order_status_id']));

        $order->recipes()->detach();
        foreach ($request->recipes as $recipe) {
            $order->recipes()->attach($recipe['recipe_id'], [
                'quantity' => $recipe['quantity'],
                'price' => $recipe['price']
            ]);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete an order
     *
     * Endpoint for deleting an order.
     *
     * Returns 204 NO_CONTENT when deleted.
     *
     * Returns 404 NOT_FOUND if the order does not exist.
     *
     * @urlParam order integer required Order ID.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order): \Illuminate\Http\JsonResponse
    {
        $order->recipes()->detach();
        $order->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Waiting orders
     *
     * Retrieve all waiting orders.
     *
     * Returns 200 OK if there is any waiting order in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "En espera", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "En espera", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function waiting(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::waiting()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Confirmed orders
     *
     * Retrieve all confirmed orders.
     *
     * Returns 200 OK if there is any confirmed order in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Confirmada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Confirmada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function confirmed(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::confirmed()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Cancelled orders
     *
     * Retrieve all cancelled orders.
     *
     * Returns 200 OK if there is any cancelled order in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Cancelada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Cancelada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function cancelled(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::cancelled()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * In Process orders
     *
     * Retrieve all orders in process.
     *
     * Returns 200 OK if there is any order in process in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "En proceso", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "En proceso", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function inProcess(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::inProcess()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Delivered orders
     *
     * Retrieve all delivered orders.
     *
     * Returns 200 OK if there is any delivered order in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Entregada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Entregada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function delivered(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::delivered()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Paid orders
     *
     * Retrieve all paid orders.
     *
     * Returns 200 OK if there is any paid order in the database.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Pagada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }},
     * {"type": "order", "id": 1, "attributes": {
     * "order_satus_id": 11, "booking_id": 22, "status": {
     * "type": "statuses", "id": 1, "attributes": {
     * "status": "Pagada", "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"}},
     * "booking": {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo"}},
     * "recipes": [{"order_id": 1, "recipe_id": 1, "recipe_name": "Estofado de ternera", "quantity": 3,
     * "price": 30.55, "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"},
     * {"order_id": 1, "recipe_id": 2, "recipe_name": "Estofado de ternera", "quantity": 3, "price": 28.99,
     * "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}],
     * "created_at": "2012/03/06 17:33:07", "updated_at": "2012/03/06 17:33:07"
     * }}]
     */
    public function paid(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderStatus::paid()->orders;

        return OrderCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }
}
