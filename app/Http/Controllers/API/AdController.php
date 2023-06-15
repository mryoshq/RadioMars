<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdController extends Controller
{
   
    public function index(Request $request)
    {
        // Fetch the authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
        if($advertiser){
            // Fetch the ads for this advertiser
            $ads = $advertiser->ads;
            // Transform them to resources
            return AdResource::collection($ads);
        }
        else{
            // If the authenticated user has no advertiser model, return empty collection
            return AdResource::collection(collect());
        }
    }
    






    public function store(Request $request)
    {
        $validated = $request->validate([
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required|in:active,not_active,paused',
        ]);
        
        $ad = Ad::create($validated); 
    
        return new AdResource($ad);
    }


    public function show(Ad $ad)
    {
        return new AdResource($ad);
    }

   
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'pack_id' => 'required|exists:packs,id',
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'status' => 'required|in:active,not_active,paused',
        ]);

        $ad->update($validated);

        return new AdResource($ad);
    }
}
