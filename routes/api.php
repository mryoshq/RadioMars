<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AdvertiserController;
use App\Http\Controllers\Api\PackController;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\AuthController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/advertiser', [AdvertiserController::class, 'show'])->name('advertiser.show');
    Route::put('/advertiser', [AdvertiserController::class, 'update'])->name('advertiser.update');
    
    Route::apiResource('ads', AdController::class);
    Route::apiResource('payments', PaymentController::class);

    Route::post('/logout', [AuthController::class, 'logout']);

 
}); 
 
Route::apiResource('packs', PackController::class)->only(['index', 'show'])->names([
    'index' => 'packs.index',
    'show' => 'packs.show',
]);


// Registration route
Route::post('/register', [AuthController::class, 'register']);

// Login route
Route::post('/login', [AuthController::class, 'login']);

