<?php

// SpotController
namespace App\Http\Controllers;


use App\Models\Spot;
use App\Models\Pack;
use App\Models\Reservation;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        return view('spots.index', compact('spots'));
    }

    public function create()
    {
        $reservations = Reservation::all();
        $packs = Pack::all();
        $statuses = ['booked', 'available'];
        return view('spots.create', compact('reservations', 'packs', 'statuses'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'pack_id' => 'nullable|exists:packs,id',
            'time_of_day' => 'required',
            'day_of_week' => 'required',
            'status' => 'required|in:booked,available',
        ]);
    
        $spot = Spot::create($validated);
    
        return redirect()->route('spots.show', $spot)->with('success', 'Spot created successfully');
    }
    

    public function show(Spot $spot)
    {
        return view('spots.show', compact('spot'));
    }

    public function edit(Spot $spot)
    {
        return view('spots.edit', compact('spot'));
    }

    public function update(Request $request, Spot $spot)
    {
        $validated = $request->validate([
            'pack_id' => 'required|exists:packs,id',
            'reservation_id' => 'required|exists:reservations,id',
            'day_of_week' => 'required',
            'time_of_day' => 'required',
            'status' => 'required',
        ]);

        $spot->update($validated);

        return redirect()->route('spots.show', $spot);
    }

    public function destroy(Spot $spot)
    {
        $spot->delete();
        return redirect()->route('spots.index');
    }
}
