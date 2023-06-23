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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes(['register' => false]); 

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['checkPermissions:manage_roles,manage_users'])->group(function () {
        Route::resource('roles', RoleController::class)->names([
            'index' => 'web.roles.index',
            'create' => 'web.roles.create',
            'store' => 'web.roles.store',
            'edit' => 'web.roles.edit',
            'update' => 'web.roles.update',
            'destroy' => 'web.roles.destroy',
        ]);

        Route::resource('users', UserController::class)->names([
            'index' => 'web.users.index',
            'create' => 'web.users.create',
            'store' => 'web.users.store',
            'edit' => 'web.users.edit',
            'update' => 'web.users.update',
            'destroy' => 'web.users.destroy',
        ]);
       

    });

    Route::middleware(['checkPermissions:manage_advertisers'])->group(function () {
        Route::resource('advertisers', AdvertiserController::class)->names([
            'index' => 'web.advertisers.index',
            'create' => 'web.advertisers.create',
            'store' => 'web.advertisers.store',
            'edit' => 'web.advertisers.edit',
            'update' => 'web.advertisers.update',
            'destroy' => 'web.advertisers.destroy',
        ]);
    });

    Route::middleware(['checkPermissions:manage_packs'])->group(function () {
        Route::resource('packs', PackController::class)->names([
            'index' => 'web.packs.index',
            'create' => 'web.packs.create',
            'store' => 'web.packs.store',
            'edit' => 'web.packs.edit',
            'update' => 'web.packs.update',
            'destroy' => 'web.packs.destroy',
        ]);
        Route::delete('/packs/{pack}/{variation}', [PackController::class, 'destroy'])->name('web.packs.destroy');

    });

    Route::middleware(['checkPermissions:manage_ads'])->group(function () {
        Route::get('/web/advertisers/ads', [PaymentController::class, 'getAds'])->name('web.payments.getAds');
        Route::get('/web/ads/packs', [AdController::class, 'getVariations'])->name('web.ads.getVariations');

        Route::resource('ads', AdController::class)->names([
            'index' => 'web.ads.index',
            'create' => 'web.ads.create',
            'store' => 'web.ads.store',
            'edit' => 'web.ads.edit',
            'update' => 'web.ads.update',
            'destroy' => 'web.ads.destroy',
        ]);
    });

    Route::middleware(['checkPermissions:manage_payments'])->group(function () {
        Route::resource('payments', PaymentController::class)->names([
            'index' => 'web.payments.index',
            'create' => 'web.payments.create',
            'store' => 'web.payments.store',
            'edit' => 'web.payments.edit',
            'update' => 'web.payments.update',
            'destroy' => 'web.payments.destroy',
        ]);
    });

    Route::get('/access-denied', function () {
        return view('access-denied');
    })->name('access-denied');
    Route::get('/recommendations', function () {
        return view('recommendations');
    })->name('recommendations');
    
});
