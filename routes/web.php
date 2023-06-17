<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertiserController;

use App\Http\Controllers\PackController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//oute::get('/advertisers/ads', [PaymentController::class, 'getAds'])->name('advertisers.getAds');



Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

Route::resource('packs', PackController::class);
Route::resource('ads', AdController::class);

Route::resource('advertisers', AdvertiserController::class);

Route::resource('payments', PaymentController::class);
