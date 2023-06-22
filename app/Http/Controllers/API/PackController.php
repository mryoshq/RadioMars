<?php

namespace App\Http\Controllers\Api;

use App\Models\Pack;
use App\Http\Resources\PackResource;
use App\Http\Controllers\Controller;

class PackController extends Controller
{
    
    public function index()
    {
        return PackResource::collection(Pack::all());
    }

    public function show(Pack $pack)
    {
        return new PackResource($pack);
    }
}
 