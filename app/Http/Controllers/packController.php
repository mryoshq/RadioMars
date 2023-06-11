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
        return view('packs.index', compact('packs'));
    }

    public function create()
    {
        return view('packs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'spots_number' => 'required|integer',
            'days_of_week' => 'nullable|array',
            'times_of_day' => 'nullable|array',
            'availability' => 'required|boolean',
        ]);
    
        $pack = Pack::create($validated);
    
        return redirect()->route('packs.show', $pack)->with('success', 'Pack created successfully');
    }
    

    public function show(Pack $pack)
    {
        return view('packs.show', compact('pack'));
    }

    public function edit(Pack $pack)
    {
        return view('packs.edit', compact('pack'));
    }

    public function update(Request $request, Pack $pack)
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'spots_number' => 'required|integer',
            'availability' => 'required',
        ]);

        $pack->update($validated);

        return redirect()->route('packs.show', $pack);
    }

    public function destroy(Pack $pack)
    {
        $pack->delete();
        return redirect()->route('packs.index');
    }
}
