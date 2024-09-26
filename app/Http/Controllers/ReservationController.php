<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();


        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant)
    {
        return view('reservations.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:50',
        ]);

        $reservation = new Reservation();
        $reservation->restaurant_id = $request->input('restaurant_id');
        $reservation->user_id = Auth::user()->id;
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_people = $request->input('reservation_people');
        $reservation->save();

        return to_route('resavations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('reservations.index');
    }
}
