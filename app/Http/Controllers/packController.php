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
        'description' => ['required', 'string', 'max:500'],
        'period' => ['required', 'array'], 
        'price' => ['required', 'array'],   
        'spots_number' => ['required', 'array'],
        'days_of_week' => ['required','array'],
        'times_of_day' => ['required','array'],
        'availability' => ['required','array'],  
    ]);

    $pack = new Pack();
    $pack->name = $validated['name'];
    $pack->description = $validated['description'];  
    $pack->period = $validated['period'];  
    $pack->price = $validated['price'];
    $pack->spots_number = $validated['spots_number'];
    $pack->days_of_week = $validated['days_of_week'];
    $pack->times_of_day = $validated['times_of_day'];

    // Added variations field
    $pack->variations = count($validated['price']);

    $availability = array_map(function ($value) {
        return boolval($value);
    }, $request->input('availability'));

    $pack->availability = $availability;
    $pack->save();

    return redirect()->route('web.packs.index', $pack)->with('success', 'Pack created successfully');
}

 

    public function edit(Pack $pack)
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $timesOfDay = ['07:25:00', '10:10:00','08:55:00','10:25:00','14:25:00', '14:55:00', '17:25:00','17:55:00', '19:10:00'];
    
        // Convert JSON-encoded strings to arrays
        $packDaysOfWeek = $pack->days_of_week;
        $packTimesOfDay = $pack->times_of_day;
    
        return view('web.packs.edit', compact('pack', 'daysOfWeek', 'timesOfDay', 'packDaysOfWeek', 'packTimesOfDay'));
    }
    
     
    public function update(Request $request, Pack $pack)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required|string|max:500',
            'period' => 'required|array',
            'price' => 'required|array',
            'spots_number' => 'required|array',
            'days_of_week' => 'required|array',
            'times_of_day' => 'required|array',
            'availability' => 'sometimes|array',
        ]);
    
        $pack->name = $validated['name'];
        $pack->description = $validated['description'];
    
        $pack->period = $validated['period']; 
        $pack->price = $validated['price'];
        $pack->spots_number = $validated['spots_number'];
    
        // Added variations field
        $pack->variations = count($validated['price']);
    
        $pack->days_of_week = $validated['days_of_week'];
        $pack->times_of_day = $validated['times_of_day'];
    
        $pack->availability = $validated['availability'];
    
        $pack->save();
    
        return redirect()->route('web.packs.index', $pack)->with('success', 'Pack updated successfully.');
    }
    

    
 
     
    
    
    
 
    public function destroy(Pack $pack, $variation)
    {
        // Remove the specific variation
        $pack->period = array_values(array_diff_key($pack->period, [$variation => ""]));
        $pack->price = array_values(array_diff_key($pack->price, [$variation => ""]));
        $pack->spots_number = array_values(array_diff_key($pack->spots_number, [$variation => ""]));
        $pack->availability = array_values(array_diff_key($pack->availability, [$variation => ""]));

        if (empty($pack->period)) {
            $pack->delete();
        } else {
            $pack->save();
        }

        return redirect()->route('web.packs.index')->with('deleted', 'Pack variation deleted successfully!');
    }

}
