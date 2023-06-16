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
            // If the authenticated user has no advertiser model, ret urn empty collection
            return AdResource::collection(collect());
        }
    }

    public function show(Request $request, $id)
    {
        // Fetch the authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
    
        // Fetch the ad with the given id that belongs to the advertiser
        $ad = $advertiser->ads()->find($id);
    
        if(!$ad){
            // If the ad does not exist, return error response
            return response()->json(['error' => 'No ad with such id for this user'], 404);
        }
    
        // Load relationships for the ad
        $ad->load('pack', 'payment');
    
        // Transform the ad to a resource
        return new AdResource($ad);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
           
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'pack_id' => 'required|exists:packs,id',
        ]);
        
        // Get the currently authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
    
        // Create a new ad associated with the advertiser 
        $ad = $advertiser->ads()->create($validated); 
    
        return new AdResource($ad);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'text_content' => 'nullable|string',
            'audio_content' => 'nullable|string',
            'pack_id' => 'required|exists:packs,id',
        ]);
    
        // Fetch the authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
    
        // Fetch the ad with the given id that belongs to the advertiser
        $ad = $advertiser->ads()->find($id);
    
        if ($ad) {
            // Update the ad
            $ad->update($validated);
    
            // Load the pack (and payment if needed) relationship
            $ad->load('pack', 'payment');
    
            return new AdResource($ad);
        } else {
            // If the ad does not exist, return error response
            return response()->json(['error' => 'No ad with such id for this user'], 404);
        }
    }
    


}
