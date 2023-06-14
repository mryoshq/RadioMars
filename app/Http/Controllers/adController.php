<?php

// AdController
namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Pack;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('ads.index', compact('ads'));
    }

    public function create()
    {
        // we need pack for the drop down selection
        $packs = Pack::all();
        $advertisers = Advertiser::all();
        return view('ads.create', compact( 'packs'));
    } 

 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'advertiser_id' => 'required|exists:advertisers,id',
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required|in:active,not_active,paused',
        ]);
        
        $ad = Ad::create($validated); 
    
        return redirect()->route('ads.show', $ad)->with('success', 'Ad created successfully');

        /*
        $request->validate([
        'advertiser_id' => 'required|exists:advertisers,id',
        'pack_id' => 'required|exists:packs,id',
        'text_content' => 'nullable|string',
        'audio_content' => 'nullable|string',
        // 'status' is not included here, because we will initially set it to 'paused'
    ]);

    $ad = Ad::create([
        'pack_id' => $request->pack_id,
        'text_content' => $request->text_content,
        'audio_content' => $request->audio_content,
        'advertiser_id' => $request->advertiser_id,
        'status' => 'paused',
    ]);
        */
     
    }
    

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required',
        ]);

        $ad->update($validated);

        return redirect()->route('ads.show', $ad);
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('ads.index');
    }
}
