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
        $ads = Ad::all();
        return view('web.ads.index', compact('ads'));
    }
    public function create()
    {
        $packs = Pack::all();
        $advertisers = Advertiser::join('users', 'advertisers.user_id', '=', 'users.id')
                                 ->select(DB::raw("CONCAT(users.name, ' - ', advertisers.id) AS name"), 'advertisers.id')
                                 ->pluck('name', 'id');
        return view('web.ads.create', compact('packs', 'advertisers'));
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
    
        return redirect()->route('web.ads.index', $ad)->with('success', 'Ad created successfully');
    }
     
    

    public function show(Ad $ad)
    {
        return view('web.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('web.ads.edit', compact('ad'));
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

        return redirect()->route('web.ads.show', $ad);
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('web.ads.index')->with('deleted', 'Ad deleted successfully!');
    }

    
 
}
