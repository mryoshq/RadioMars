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



Route::resource('roles', RoleController::class)->names([
    'index' => 'web.roles.index',
    'create' => 'web.roles.create',
    'store' => 'web.roles.store',
    'show' => 'web.roles.show',
    'edit' => 'web.roles.edit',
    'update' => 'web.roles.update',
    'destroy' => 'web.roles.destroy',
]);

Route::resource('users', UserController::class)->names([
    'index' => 'web.users.index',
    'create' => 'web.users.create',
    'store' => 'web.users.store',
    'show' => 'web.users.show',
    'edit' => 'web.users.edit',
    'update' => 'web.users.update',
    'destroy' => 'web.users.destroy',
]);

Route::resource('packs', PackController::class)->names([
    'index' => 'web.packs.index',
    'create' => 'web.packs.create',
    'store' => 'web.packs.store',
    'show' => 'web.packs.show',
    'edit' => 'web.packs.edit',
    'update' => 'web.packs.update',
    'destroy' => 'web.packs.destroy',
]);


Route::get('/web/advertisers/ads', [PaymentController::class, 'getAds'])->name('web.payments.getAds');

Route::resource('ads', AdController::class)->names([
    'index' => 'web.ads.index',
    'create' => 'web.ads.create',
    'store' => 'web.ads.store',
    'show' => 'web.ads.show',
    'edit' => 'web.ads.edit',
    'update' => 'web.ads.update',
    'destroy' => 'web.ads.destroy',
]);

Route::resource('advertisers', AdvertiserController::class)->names([
    'index' => 'web.advertisers.index',
    'create' => 'web.advertisers.create',
    'store' => 'web.advertisers.store',
    'show' => 'web.advertisers.show',
    'edit' => 'web.advertisers.edit',
    'update' => 'web.advertisers.update',
    'destroy' => 'web.advertisers.destroy',
]);

Route::resource('payments', PaymentController::class)->names([
    'index' => 'web.payments.index',
    'create' => 'web.payments.create',
    'store' => 'web.payments.store',
    'show' => 'web.payments.show',
    'edit' => 'web.payments.edit',
    'update' => 'web.payments.update',
    'destroy' => 'web.payments.destroy',
]);




