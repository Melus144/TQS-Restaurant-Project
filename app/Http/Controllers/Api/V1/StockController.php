<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockRequest;
use App\Http\Resources\StockCollection;
use App\Http\Resources\StockResource;
use App\Models\Food;
use App\Models\Stock;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Stock
 *
 * Endpoints for stock management
 */
class StockController extends Controller
{
    /**
     * Get all stocks
     *
     * Retrieve all stocks from database.
     *
     * Returns 200 OK if database contains any stock.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"type": "stocks", "id": 1, "attributes":
     * {"quantity": 7, "expiration_date": "2022/04/13 21:30:00", "expired": false,
     * "food_id": 5, "created_at": "2022/04/13 21:30:00",
     * "updated_at": "2022/04/13 21:30:00"}},
     * {"type": "stocks", "id": 2, "attributes":
     * {"quantity": 8, "expiration_date": "2022/04/13 21:30:00", "expired": true,
     * "food_id": 6, "created_at": "2022/04/13 21:30:00",
     * "updated_at": "2022/04/13 21:30:00"}}]
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $stocks = Stock::all();

        return StockCollection::make($stocks)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create a stock
     *
     * Endpoint for creating a stock.
     *
     * Returns 201 CREATED when created.
     *
     * @param StockRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockRequest $request): \Illuminate\Http\JsonResponse
    {
        Stock::create($request->validated());
        Food::find($request->food_id)->setNonExpiredStocks();

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Get a single stock
     *
     * User retrieves a single stock from database.
     *
     * Returns 200 OK if stock exists.
     *
     * @param Stock $stock
     * @return \Illuminate\Http\JsonResponse
     * @response 200 {"type": "stocks", "id": 1, "attributes":
     * {"quantity": 7, "expiration_date": "2022/04/13 21:30:00", "expired": false,
     * "food_id": 5, "created_at": "2022/04/13 21:30:00",
     * "updated_at": "2022/04/13 21:30:00"}}
     */
    public function show(Stock $stock): \Illuminate\Http\JsonResponse
    {
        return StockResource::make($stock)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update a stock
     *
     * Endpoint for updating a stock.
     *
     * Returns 204 NO_CONTENT when updated.
     *
     * @param StockRequest $request
     * @param Stock $stock
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StockRequest $request, Stock $stock)
    {
        $stock->quantity = $request->quantity;
        $stock->expiration_date = $request->expiration_date;
        if ($request->has('expired')) $stock->expired = $request->expired;
        $stock->food_id = $request->food_id;
        $stock->save();

        Food::find($request->food_id)->setNonExpiredStocks();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a stock
     *
     * Endpoint for deleting a stock.
     *
     * Returns 204 NO_CONTENT when deleted.
     *
     * @param Stock $stock
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Get all expired stocks
     *
     * Retrieve all expired stocks from database.
     *
     * Returns 200 OK if database contains any expired stock.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function expired(): \Illuminate\Http\JsonResponse
    {
        $stocks = Stock::whereDate('expiration_date', '<=', \Carbon\Carbon::now()->toDateString())
            ->orWhere('expired', true)
            ->get();

        return StockCollection::make($stocks)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Get all non-expired stocks
     *
     * Retrieve all non-expired stocks from database.
     *
     * Returns 200 OK if database contains any non-expired stock.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function nonExpired(): \Illuminate\Http\JsonResponse
    {
        $stocks = Stock::whereDate('expiration_date', '>=', \Carbon\Carbon::now()->toDateString())
            ->orWhere('expired', false)
            ->get();

        return StockCollection::make($stocks)->response()->setStatusCode(Response::HTTP_OK);
    }
}
