<?php

// SpotController
namespace App\Http\Controllers;

use App\Models\Spot;
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
        return view('spots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'day_of_week' => 'required',
            'time_of_day' => 'required',
        ]);
 
        $spot = Spot::create($validated);

        return redirect()->route('spots.show', $spot);
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
            'ad_id' => 'required|exists:ads,id',
            'day_of_week' => 'required',
            'time_of_day' => 'required',
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
