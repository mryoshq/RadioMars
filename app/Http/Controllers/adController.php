<?php

// AdController
namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Pack;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('pack', 'advertiser.user', 'payment')->get(); 
        return view('web.ads.index', compact('ads'));
    }
    public function getVariations(Request $request)
    {
        $packId = $request->input('pack_id');
        $pack = Pack::find($packId);
    
        if($pack){
            $variations = range(1, $pack->variations);
        } else {
            $variations = [];
        }
    
        return response()->json($variations);
    }
    

    public function create()
    {
        $packs = Pack::all();
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        $variations = [];
        foreach ($packs as $pack) {
            $variations[$pack->id] = range(1, $pack->variations);
        }
        return view('web.ads.create', compact('packs', 'advertisers', 'variations'));
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
    
        $pack = Pack::find($request->pack_id);
    
        $request->validate([
            'pack_variation' => ['required', 'integer', 'between:1,' . $pack->variations]
        ]);
    
        $ad = Ad::create($validated + ['pack_variation' => $request->pack_variation]);
    
        return redirect()->route('web.ads.index', $ad)->with('success', 'Ad created successfully');
    }
    
    
     
    public function show(Ad $ad)
    {
        return view('web.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        $packs = Pack::select(DB::raw("CONCAT(name, ' - ', id) AS name"), 'packs.id')
                     ->pluck('name', 'id');
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
    
        return view('web.ads.edit', compact('ad', 'packs', 'advertisers'));
    }
     
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'advertiser_id' => 'sometimes|exists:advertisers,id',
            'pack_id' => 'sometimes|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required|in:active,not_active,paused',
            'pack_variation' => 'sometimes|integer',
        ]);
    
        $updateData = $validated;
    
        if ($request->input('advertiser_id_disabled') === 'true') {
            $updateData['advertiser_id'] = $ad->advertiser_id;
        }
    
        if ($request->input('pack_id_disabled') === 'true') {
            $updateData['pack_id'] = $ad->pack_id;
        }
    
        if ($request->input('pack_variation_disabled') === 'true') {
            $updateData['pack_variation'] = $ad->pack_variation;
        }
        $ad->update($updateData);
    
        return redirect()->route('web.ads.index')->with('success', 'Ad updated successfully');
    }
    
    
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('web.ads.index')->with('deleted', 'Ad deleted successfully!');
    }
 
}
