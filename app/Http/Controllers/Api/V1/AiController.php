<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PredictionRequest;
use App\Http\Resources\AiDataCollection;
use App\Http\Resources\AiDataResource;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\DatabaseObject;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group AI
 *
 * Endpoints for AI management
 */
class AiController extends Controller
{
    /**
     * Get retrain data
     *
     * User retrieves all retrain data
     *
     * Returns 200 OK if database contains any data.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 [{"date": "2022/04/13 21:30:00", "food_types": ["type1", "type2"],
     * "festive": true},
     * {"date": "2022/04/13 21:30:00", "food_types": ["type3", "type4"],
     * "festive": true}
     * ]
     */
    public function getData(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::all();

        return AiDataCollection::make($orders)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Get predictions
     *
     * User retrieves predictions based on a request.
     *
     * Returns 200 OK if database contains any prediction.
     *
     * Returns 503 SERVICE_UNAVAILABLE if request can't be processed.
     *
     * @return \Illuminate\Http\JsonResponse
     * @response 200 { "persons": 3, "recipe":"Cárnicos" }
     * @response 503 { "message": "El servicio no está disponible en este momento." }
     */
    public function getPredictions(PredictionRequest $request): \Illuminate\Http\JsonResponse
    {
        $dateFromRequest = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->get('date'));
        $date = $dateFromRequest->format('d-m-Y');
        $festive = $request->get('festive') ? 'Si' : 'No';
        $people = Booking::where('date', '=', $dateFromRequest->toDateTimeString())->sum('people');

        $url = "https://flask-heroku-srm-linux.herokuapp.com/srm-predict/$date,$festive,$people";

        try {
            $response = Http::get($url);
            $predictions = explode('%', $response->json());

            return response()->json([
                'persons' => $predictions[0],
                'recipe' => $predictions[1]
            ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'El servicio no está disponible en este momento.'
            ], \Symfony\Component\HttpFoundation\Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Get Retrain Customers
     *
     * Activates retrain model for customers.
     *
     * Returns 200 OK.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrainCustomers(): \Illuminate\Http\JsonResponse
    {
        Http::get('https://flask-heroku-srm-linux.herokuapp.com/srm-retrain-customers');

        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Get Retrain Food
     *
     * Activates retrain model for foods.
     *
     * Returns 200 OK.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrainFood(): \Illuminate\Http\JsonResponse
    {
        Http::get('https://flask-heroku-srm-linux.herokuapp.com/srm-retrain-food');

        return response()->json(null, \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    private function getFestive($date): string
    {
        if ($date->isSaturday() || $date->isSunday()) {
            return 'Yes';
        }

        return 'No';
    }
}
