<?php

// ReservationController
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ad;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $ads = Ad::all();
        return view('reservations.create', compact('ads'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
    
        $reservation = Reservation::create($validated);
    
        return redirect()->route('reservations.show', $reservation)->with('success', 'Reservation created successfully');
    }
    

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
}
