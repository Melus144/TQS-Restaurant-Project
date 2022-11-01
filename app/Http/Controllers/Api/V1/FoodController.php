<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Http\Resources\FoodCollection;
use App\Http\Resources\FoodResource;
use App\Http\Resources\StockCollection;
use App\Models\Food;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Food
 *
 * Endpoints for food management
 */
class FoodController extends Controller
{
    /**
     * Return all foods
     *
     * Retrieve all foods from database.
     *
     * Returns 200 OK if database contains any food.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "food", "id": 1, "attributes": {"name":"foo", "units": 1,
     * "created_at": "2022/04/13 21:30:00", "updated_at": "2022/04/13 21:30:00"}},
     * {"type": "food", "id": 2, "attributes": {"name":"foo2", "units": 1,
     * "created_at": "2022/04/13 21:30:00", "updated_at": "2022/04/13 21:30:00"}}]
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $food = Food::all();

        return FoodCollection::make($food)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create a food
     *
     * Endpoint for creating food.
     *
     * Return 201 CREATED when created.
     *
     * @param FoodRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FoodRequest $request): \Illuminate\Http\JsonResponse
    {
        Food::create($request->validated());

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Get a single food
     *
     * User retrieves a single food from database.
     *
     * Returns 200 OK if food exists.
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     * @response 200 {"type": "food", "id": 1, "attributes": {"name":"foo", "units": 1,
     * "created_at": "2022/04/13 21:30:00", "updated_at": "2022/04/13 21:30:00"}}
     */
    public function show(Food $food): \Illuminate\Http\JsonResponse
    {
        return FoodResource::make($food)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update a food
     *
     * Endpoint for updating food.
     *
     * Returns 204 NO_CONTENT when updated.
     *
     * @param FoodRequest $request
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FoodRequest $request, Food $food): \Illuminate\Http\JsonResponse
    {
        $food->name = $request->name;
        $food->units = $request->units;
        $food->type = $request->type;
        $food->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a food
     *
     * Endpoint for deleting food.
     *
     * Returns 204 NO_CONTENT when deleted.
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Food $food): \Illuminate\Http\JsonResponse
    {
        if (count($food->recipes) > 0 || count($food->stocks) > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el alimento debido a que es usado en alguna receta o contiene stocks.'
            ], Response::HTTP_CONFLICT);
        }

        $food->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Single food's stock
     *
     * User retrieves all stock of a single food.
     *
     * Returns 200 OK if food exists and has stock.
     *
     * @param Food $food
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "stocks", "id": 1, "food_id": 1, "food": {"type": "food", "id": 1, "attributes": {"name":"foo", "units": 1,
     * "created_at": "2022/04/13 21:30:00", "updated_at": "2022/04/13 21:30:00"}}, "attributes": {"quantity":"10", "expiration_date":
     * "2022/04/13 21:30:00", "expired": false, "created_at": "2022/04/13 21:30:00", "updated_at": "2022/04/13 21:30:00"}}]
     */
    public function stocks(Food $food): \Illuminate\Http\JsonResponse
    {
        $stocks = $food->stocks;

        return StockCollection::make($stocks)->response()->setStatusCode(Response::HTTP_OK);
    }
}
