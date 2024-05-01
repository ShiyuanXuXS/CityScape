<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$userId = Auth::id();
        $reservations = Reservation::where('user_id', Auth::id())->latest()->paginate(5);
        return view('reservations.index')->with('reservations', $reservations);
        //dd($reservation);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hotel_rooms = RoomController::readRooms();
        return view('reservations.create')->with('hotel_rooms', $hotel_rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate data from request
        $request->validate([
            'hotel_name' => 'required',
            'hotel_name' => Rule::in(RoomController::getHotelNames()),
            'checkin_date' => 'required|date|after:yesterday',
            'checkout_date' => 'required|date|after:checkin_date',
            'room_number' => 'required|max:20',
            'room_number' => Rule::in(RoomController::getAvailableRooms($_POST["hotel_name"], $_POST["checkin_date"], $_POST["checkout_date"], null, true))
        ]);
        $room = RoomController::getRoom($request->hotel_name, $request->room_number);
        $userId = Auth::id();
        $user_checkin_date = Carbon::createFromDate($request->checkin_date)->format('y-m-d');
        $user_checkout_date = Carbon::createFromDate($request->checkout_date)->format('y-m-d');

        //to prevent conflict, use sql statement instead of save()function
        $queryStr = "insert into reservations 
        (user_id, hotel_name, room_number, room_capacity, room_rate, checkin_date, checkout_date, created_at, updated_at) 
        SELECT distinct {$userId} as user_id, 
        '{$request->hotel_name}' as hotel_name, 
        '{$request->room_number}' as room_number, 
        {$room["room_capacity"]} as room_capacity, 
        {$room["room_rate"]} as room_rate, 
        '{$user_checkin_date}' as checkin_date, 
        '{$user_checkout_date}' as checkout_date, 
        now() as created_at, 
        now() as updated_at 
        FROM `reservations` 
        WHERE 0 in 
        (select count(*) as conflict
        from reservations
        where hotel_name='{$request->hotel_name}' 
        and room_number='{$request->room_number}' 
        and (checkin_date < '{$user_checkout_date}' and checkout_date > '{$user_checkin_date}')
        )";
        //dd($queryStr);
        DB::insert($queryStr);

        /*$reservation = new Reservation([
            //validations
        ]);
        $reservation->save(); */

        return to_route("reservations.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //$reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($reservation->user_id != Auth::id()) {
            return abort(403);
        }
        return view('reservations.show')->with("reservation", $reservation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        if ($reservation->user_id != Auth::id()) {
            return abort(403);
        }
        $hotel_rooms = RoomController::readRooms();
        return view('reservations.edit')->with("reservation", $reservation)->with('hotel_rooms', $hotel_rooms);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id != Auth::id()) {
            return abort(403);
        }
        $request->validate([
            'hotel_name' => 'required',
            'hotel_name' => Rule::in($reservation->hotel_name),
            'checkin_date' => 'required|date|after:yesterday',
            'checkout_date' => 'required|date|after:checkin_date',
            'room_number' => 'required|max:20',
            'room_number' => Rule::in(RoomController::getAvailableRooms($reservation->hotel_name, $_POST["checkin_date"], $_POST["checkout_date"], $reservation->id, true))
        ]);
        $room = RoomController::getRoom($request->hotel_name, $request->room_number);
        $user_checkin_date = Carbon::createFromDate($request->checkin_date)->format('y-m-d');
        $user_checkout_date = Carbon::createFromDate($request->checkout_date)->format('y-m-d');
        //to prevent conflict, use sql statement instead of save()function
        $queryStr =
            "UPDATE reservations
        JOIN (
            SELECT {$reservation->id} as id, 
                '{$request->room_number}' as room_number, 
                {$room["room_capacity"]} as room_capacity, 
                {$room["room_rate"]} as room_rate, 
                '{$user_checkin_date}' as checkin_date, 
                '{$user_checkout_date}' as checkout_date
            WHERE 0 in 
                (select count(*) as conflict
                from reservations
                where hotel_name='{$request->hotel_name}' 
                    and room_number='{$request->room_number}' 
                    and checkin_date < '{$user_checkout_date}' 
                    and checkout_date > '{$user_checkin_date}' 
                    and id<>{$reservation->id}
                )
            ) AS r 
            ON reservations.id = r.id
        SET reservations.room_number = r.room_number,
            reservations.room_capacity = r.room_capacity,
            reservations.room_rate = r.room_rate,
            reservations.checkin_date = r.checkin_date,
            reservations.checkout_date = r.checkout_date,
            reservations.updated_at = now()";
        //dd($queryStr);
        DB::update($queryStr);

        return to_route('reservations.show', $reservation)->with('success', 'Reservation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id != Auth::id()) {
            return abort(403);
        }
        $reservation->delete();
        return to_route('reservations.index')->with('success', 'Reservation deletedd successfully');
    }
}
