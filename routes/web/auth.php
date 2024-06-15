<?php

use App\Http\Controllers\Shared\AuthController;
use App\Http\Controllers\Shared\PromosiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web for authentication proces
|--------------------------------------------------------------------------
|
| we separate web route for authenticate process to make web routes in web.php more
| clean and easy to maintain authenticate process routes in here
| In here, auth process like login process and pages that displayed before auth user login
|
*/
/**
 * route for fallback kader routes
 */
Route::fallback(function () {
    return view('404');
});

/**
 * routes for landing page and authenticate process
 */
Route::get('/', [PromosiController::class, 'landingpage']);
Route::get('/read={id}', [PromosiController::class, 'read']);
Route::get('/profil', [PromosiController::class, 'profil'])->name('profil');
Route::get('/jadwal', [PromosiController::class, 'jadwal']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.auth');
