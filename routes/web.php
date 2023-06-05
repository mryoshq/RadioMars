<?php
use Illuminate\Support\Facades\Route;

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


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/packs', [App\Http\Controllers\packsController::class, 'index'])->name('packs');
Route::get('/users', [App\Http\Controllers\usersController::class, 'index'])->name('users');
Route::get('/ads', [App\Http\Controllers\adsController::class, 'index'])->name('ads');
Route::get('/payments', [App\Http\Controllers\paymentsController::class, 'index'])->name('payments');




