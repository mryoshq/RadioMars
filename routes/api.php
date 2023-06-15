<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AdvertiserController;
use App\Http\Controllers\Api\PackController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\PaymentController;

/*
|-------------------------------------------------------------------------- 
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API! ´
|
*/ 



Route::apiResource('packs', PackController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/advertiser', [AdvertiserController::class, 'show']);
    Route::put('/advertiser', [AdvertiserController::class, 'update']);
    Route::apiResource('ads', AdController::class)->except(['destroy']);
    Route::apiResource('payments', PaymentController::class)->except(['destroy']);
});
