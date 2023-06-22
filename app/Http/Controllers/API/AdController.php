<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    
        // Transform the ad to a resource and pass pack_variation
        return (new AdResource($ad))->additional(['pack_variation' => $ad->pack_variation]);
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text_content' => 'required_without:audio_content|string|nullable',
            'audio_content' => 'required_without:text_content|string|nullable',
            'pack_id' => 'required|exists:packs,id',
            'pack_variation' => 'required|string',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }
    
        $validated = $validator->validated();
    
        $validated['decision'] = 'in_queue';
        $validated['message'] = 'we will process your ad soon';
        $validated['programmed_for'] = $request->input('programmed_for', now()->addDay());
    
        // Get the currently authenticated user's advertiser
        $advertiser = $request->user()->advertiser;
    
        // Create a new ad associated with the advertiser
        $ad = $advertiser->ads()->create($validated);
    
        // Load the pack (and payment if needed) relationship
        $ad->load('pack', 'payment');
    
        return new AdResource($ad);
    }
    
    

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'text_content' => 'required_without:audio_content|string|nullable',
        'audio_content' => 'required_without:text_content|string|nullable',
        'pack_id' => 'required|exists:packs,id',
        'pack_variation' => 'required|string',
    ]);

    if($validator->fails()){
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 400);
    }

    $validated = $validator->validated();

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
 