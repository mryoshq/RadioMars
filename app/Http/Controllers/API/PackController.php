<?php

namespace App\Http\Controllers\Api;

use App\Models\Pack;
use App\Http\Resources\PackResource;
use App\Http\Controllers\Controller;

class PackController extends Controller 
{
    /**
     * Show all packs
     *
     * This function retrieves all packs in the database and returns them as a resource collection.
     * Each pack is transformed into a JSON object by the PackResource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try {
            return PackResource::collection(Pack::all());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve packs. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific pack
     *
     * This function retrieves a specific pack from the database using its ID and returns it as a JSON object
     * The pack is transformed by the PackResource.
     *
     * @param  \App\Models\Pack  $pack
     * @return \App\Http\Resources\PackResource
     */
    public function show(Pack $pack)
    {
        try {
            if (!$pack) {
                return response()->json(['message' => 'Pack not found'], 404);
            }

            return new PackResource($pack);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve pack. ' . $e->getMessage()
            ], 500);
        }
    }
}
 