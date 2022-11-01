<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Bookings
 *
 * Endpoints for bookings management
 */
class BookingController extends Controller
{
    /**
     * Get all bookings
     *
     * Retrieve all bookings from database.
     *
     * Returns 200 OK if database contains any booking.
     * @return \Illuminate\Http\JsonResponse
     * @response [{"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo", "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}},
     * {"type": "bookings", "id": 2, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo", "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}}]
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $recipes = Booking::all();

        return BookingCollection::make($recipes)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create a booking
     *
     * Endpoint for creating a booking.
     *
     * Returns 201 CREATED when created.
     *
     * Returns 422 UNPROCESSABLE_ENTITY if there are more than 50 bookings within a range of 2 hours before and 2 hours later from the current time.
     *
     * @param BookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingRequest $request): \Illuminate\Http\JsonResponse
    {
        // Get date 2 hours before booking request date
        $beforeDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->get('date'))
            ->subHours(2);

        // Get date 2 hours after booking request date
        $afterDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->get('date'))
            ->addHours(2);

        // Get total of bookings between limits
        $totalPeople = Booking::where('date', '>=', $beforeDate->toDateTimeString())
            ->where('date', '<=', $afterDate->toDateTimeString())->sum('people') + $request->get('people');

        if ($totalPeople > config('bookings.maximum_capacity')) {
            return response()->json([
                'message' => 'No se puede realizar la reserva debido a que se ha superado el aforo máximo.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $booking = Booking::create($request->validated());

        return response()->json([], Response::HTTP_CREATED);
    }

    /**
     * Get a single booking
     *
     * User retrieves a single booking from database.
     *
     * Returns 200 OK if booking exists.
     *
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     * @response 200 scenario="Booking exists" {"type": "bookings", "id": 1, "attributes": {"name":"foo booking", "email": "foo@foo.com",
     * "phone": "+34 111 111 111", "date": "2022/04/13 21:30:00",
     * "people": 6, "table": "foo", "created_at": "2012/03/06 17:33:07",
     * "updated_at": "2012/03/06 17:33:07"}}
     */
    public function show(Booking $booking): \Illuminate\Http\JsonResponse
    {
        return BookingResource::make($booking)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update a booking
     *
     * Endpoint for updating a booking.
     *
     * Returns 204 NO_CONTENT when updated.
     *
     * Returns 422 UNPROCESSABLE_ENTITY if there are more than 50 bookings within a range of 2 hours before and 2 hours later from the current time.
     * This only applies to the case of modifying booking's date parameter.
     *
     * @param BookingRequest $request
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookingRequest $request, Booking $booking): \Illuminate\Http\JsonResponse
    {
        // Get date 2 hours before booking request date
        $beforeDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->get('date'))
            ->subHours(2);

        // Get date 2 hours after booking request date
        $afterDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->get('date'))
            ->addHours(2);

        // Get total of bookings between limits
        $createdBookings = Booking::where('date', '>=', $beforeDate->toDateTimeString())
                ->where('date', '<=', $afterDate->toDateTimeString())->get();

        $totalPeople = Booking::where('date', '>=', $beforeDate->toDateTimeString())
            ->where('date', '<=', $afterDate->toDateTimeString())->sum('people');

        if ($createdBookings->contains($booking)) {
            $totalPeople = $totalPeople - $booking->people + $request->get('people');
        } else {
            $totalPeople = $totalPeople + $request->get('people');
        }

        if ($totalPeople > config('bookings.maximum_capacity')) {
            return response()->json([
                'message' => 'No se puede realizar la reserva debido a que se ha superado el aforo máximo.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $booking->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a booking
     *
     * Endpoint for deleting a booking.
     *
     * Returns 204 NO_CONTENT when deleted.
     *
     * Returns 409 CONFLICT if booking has 1 or more orders.
     *
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Booking $booking): \Illuminate\Http\JsonResponse
    {
        if (count($booking->orders) > 0) {
            return response()->json([
                'message' => 'No se puede eliminar la reserva debido a que contiene comandas.'
            ], Response::HTTP_CONFLICT);
        }

        $booking->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
