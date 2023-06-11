<?php

// AdController
namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Models\Campaign;
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
        $campaigns = Campaign::all();
        $packs = Pack::all();
        return view('ads.create', compact('campaigns', 'packs'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required|in:active,not_active,paused',
        ]);
    
        $ad = Ad::create($validated);
    
        return redirect()->route('ads.show', $ad)->with('success', 'Ad created successfully');
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
            'campaign_id' => 'required|exists:campaigns,id',
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'required',
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
