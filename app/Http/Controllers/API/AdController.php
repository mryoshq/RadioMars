<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdController extends Controller
{
   /**
     * Display a listing of the ads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function index(Request $request) 
    {
        try {
            $advertiser = $request->user()->advertiser;
    
            if(!$advertiser){
                return response()->json(['error' => 'No advertiser associated with this user'], 404);
            }
    
            $ads = $advertiser->ads;
            return AdResource::collection($ads);
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    

    /**
     * Display the specified ad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\AdResource
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function show(Request $request, $id)
    {
        try {
            $advertiser = $request->user()->advertiser;
    
            if(!$advertiser){
                return response()->json(['error' => 'No advertiser associated with this user'], 404);
            }
    
            $ad = $advertiser->ads()->find($id);
    
            if(!$ad){
                return response()->json(['error' => 'No ad with such id for this user'], 404);
            }
    
            $ad->load('pack', 'payment');
            return (new AdResource($ad));
    
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
        
    /**
     * Store a newly created ad in the database.
     *
     * @bodyParam text_content string required_without:audio_content The text content of the ad. Example: "This is a sample text ad."
     * @bodyParam audio_content string required_without:text_content The audio content of the ad.
     * @bodyParam pack_id integer required The ID of the pack associated with the ad. Example: 1
     * @bodyParam pack_variation integer required The variation of the pack associated with the ad. Example: 1
     * @bodyParam programmed_for date required The date when the ad is programmed for. Example: 2023-06-25
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\AdResource
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function store(Request $request)
    {
        $messages = [
            'text_content.required_without' => 'The text content field is required when audio content is not present.',
            'text_content.string' => 'The text content must be a string.',
            'audio_content.required_without' => 'The audio content field is required when text content is not present.',
            'audio_content.string' => 'The audio content must be a string.',
            'pack_id.required' => 'The pack id field is required.',
            'pack_id.integer' => 'The pack id must be an integer.',
            'pack_id.exists' => 'The selected pack id is invalid.',
            'pack_variation.required' => 'The pack variation field is required.',
            'pack_variation.integer' => 'The pack variation must be an integer.',
            'programmed_for.required' => 'The programmed for field is required.',
            'programmed_for.date' => 'The programmed for field must be a valid date.',
        ];
    
        try { 
            $validated = $request->validate([
                'text_content' => 'required_without:audio_content|string|nullable',
                'audio_content' => 'required_without:text_content|string|nullable',
                'pack_id' => 'required|integer|exists:packs,id',
                'pack_variation' => 'required|integer',
                'programmed_for' => 'required|date',
            ], $messages);
    
            $validated['decision'] = 'in_queue';
            $validated['message'] = 'We will process your ad soon.';
    
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found.'], 404);
            }
    
            $ad = $advertiser->ads()->create($validated);
            if (!$ad) {
                return response()->json(['error' => 'Failed to create the Ad.'], 500);
            }
    
            $ad->load('pack', 'payment');
    
            return new AdResource($ad);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // handle validation exception
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // catch other errors
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
    
    /**
     * Update the specified ad in the database.
     *
     * @bodyParam text_content string required_without:audio_content The text content of the ad. Example: "Updated sample text ad."
     * @bodyParam audio_content string required_without:text_content The audio content of the ad.
     * @bodyParam pack_id integer The ID of the pack associated with the ad. Example: 1
     * @bodyParam pack_variation integer The variation of the pack associated with the ad. Example: 1
     * @bodyParam programmed_for date The date when the ad is programmed for. Example: 2023-06-26
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\App\Http\Resources\AdResource
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     * @urlParam id integer required The ID of the ad. Example: 1
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'text_content.required_without' => 'The text content field is required when audio content is not present.',
            'text_content.string' => 'The text content must be a string.',
            'audio_content.required_without' => 'The audio content field is required when text content is not present.',
            'audio_content.string' => 'The audio content must be a string.',
            'pack_id.integer' => 'The pack id must be an integer.',
            'pack_id.exists' => 'The selected pack id is invalid.',
            'pack_variation.integer' => 'The pack variation must be an integer.',
            'programmed_for.date' => 'The programmed for field must be a valid date.',
        ];

        try {
            $ad = Ad::find($id);
            if (!$ad) {
                return response()->json(['error' => 'Ad not found.'], 404);
            }

            $data = $request->validate([
                'text_content' => 'sometimes|required_without:audio_content|string|nullable',
                'audio_content' => 'sometimes|required_without:text_content|string|nullable',
                'pack_id' => 'sometimes|integer|exists:packs,id',
                'pack_variation' => 'sometimes|integer',
                'programmed_for' => 'sometimes|date',
            ], $messages);

            $advertiser = $request->user()->advertiser;
            if ($ad->advertiser_id !== $advertiser->id) {
                return response()->json(['error' => 'Unauthorized to update this Ad.'], 403);
            }

            $ad->update($data);

            $ad->load('pack', 'payment');

            return new AdResource($ad);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // handle validation exception
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // catch other errors
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    }
    