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
 


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/advertiser', [AdvertiserController::class, 'show'])->name('advertiser.show');
    Route::put('/advertiser', [AdvertiserController::class, 'update'])->name('advertiser.update');
    
    Route::apiResource('ads', AdController::class);
    Route::apiResource('payments', PaymentController::class);

}); 

Route::apiResource('packs', PackController::class)->only(['index', 'show'])->names([
    'index' => 'packs.index',
    'show' => 'packs.show',
]);



Route::apiResource('packs', PackController::class)->only(['index', 'show'])->names([
    'index' => 'packs.index',
    'show' => 'packs.show',
]);
