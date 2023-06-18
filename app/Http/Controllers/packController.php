<?php

// PackController
namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;
 

class PackController extends Controller
{
    public function index()
    {
        $packs = Pack::all();
        return view('web.packs.index', compact('packs'));
    }

    public function create()
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timesOfDay = ['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00'];
    
        return view('web.packs.create', compact('daysOfWeek', 'timesOfDay'));
    }
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'spots_number' => ['required', 'integer'],
            'days_of_week' => ['array'],
            'times_of_day' => ['array'],
            'availability' => ['boolean'],
        ]);
     
        $pack = new Pack();
        $pack->name = $validated['name'];
        $pack->price = $validated['price'];
        $pack->spots_number = $validated['spots_number'];
        $pack->days_of_week = json_encode($validated['days_of_week']);
        $pack->times_of_day = json_encode($validated['times_of_day']);
        $pack->availability = $validated['availability'] ?? false;
        $pack->save();
    
        return redirect()->route('web.packs.index', $pack)->with('success', 'Pack created successfully');
    }
    
    
 
    public function show(Pack $pack)
    {
        return view('web.packs.show', compact('pack'));
    }

    public function edit(Pack $pack)
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timesOfDay = ['07:25:00', '10:10:00','08:55:00','10:25:00','14:25:00', '14:55:00', '17:25:00','17:55:00', '19:10:00'];
    
        // Convert JSON-encoded strings to arrays
        $packDaysOfWeek = json_decode($pack->days_of_week, true);
        $packTimesOfDay = json_decode($pack->times_of_day, true);
    
        return view('web.packs.edit', compact('pack', 'daysOfWeek', 'timesOfDay', 'packDaysOfWeek', 'packTimesOfDay'));
    }
    
     
    public function update(Request $request, Pack $pack)
    {
        //dd($request); 
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'spots_number' => 'required|integer',
            'days_of_week' => 'required|array',
            'times_of_day' => 'required|array',
            'availability' => 'sometimes|boolean',
        ]);
    
       // dd($validated['days_of_week'], $validated['times_of_day']);
    
        $pack->name = $validated['name'];
        $pack->price = $validated['price'];
        $pack->spots_number = $validated['spots_number'];
        $pack->days_of_week = json_encode($validated['days_of_week']);
        $pack->times_of_day = json_encode($validated['times_of_day']);
        $pack->availability = $validated['availability'] ?? false;

    
        $pack->save();
    
        return redirect()->route('web.packs.index', $pack)->with('success', 'Pack updated successfully.');
    }
    
    
    
    
    
 
    public function destroy(Pack $pack)
    {
        $pack->delete();
        return redirect()->route('web.packs.index')->with('deleted', 'Pack deleted successfully!');
    }
}
