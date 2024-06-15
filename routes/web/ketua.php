<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Ketua\BantuanController;
use App\Http\Controllers\Ketua\PenerimaController;
use App\Http\Controllers\Shared\AuthController;
use App\Http\Controllers\Shared\DashboardController;
use App\Http\Controllers\Shared\ProfileController;

/*
|--------------------------------------------------------------------------
| Web for ketua role
|--------------------------------------------------------------------------
|
| we separate web route for role ketua to make web routes in web.php more
| clean and easy to maintain ketua route in here
|
*/
Route::group([
    'middleware' => ['auth', 'checkLevel:ketua'],
    'prefix' => 'ketua'
    ], function () {
        /**
         * route for fallback kader routes
         */
        Route::fallback(function () {
            return view('404');
        });

        /**
         * routes for dasboard and profile ketua
         */
        Route::get('/', [DashboardController::class, 'indexKetua'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'indexKetua'])->name('ketua.profile');
        Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('ketua.profile.update');
        Route::get('/foto/{id}/{updated_at}', [ProfileController::class, 'delete'])->name('ketua.foto.delete');

        /**
         * routes for bantuan and penerima feature
         */
        Route::group(['prefix' => 'bantuan'], function () {
            Route::get('/', [BantuanController::class, 'index']);
            Route::get('/penerima', [BantuanController::class, 'tambah'])->name('ketua.penerima');
            Route::post('/konfirmasi', [BantuanController::class, 'konfirmasi'])->name('ketua.konfirmasi');
            Route::get('/detail/{id}', [BantuanController::class, 'detail'])->name('ketua.bantuan.detail');
            Route::get('/detail/update', [BantuanController::class, 'indexbantuan'])->name('ketua.detail.update');
        });
        Route::group(['prefix' => 'penerima'], function () {
            Route::get('/', [PenerimaController::class, 'index']);
            Route::get('/tambah', [PenerimaController::class, 'tambah']);

        });
        Route::group(['prefix' => 'spk'], function() {
            Route::get('/', function(){
                return view('ketua.spk.index');
            });
            Route::get('/', function(){
                return view('ketua.spk.kriteria');
            });
        });

        /**
         * route for logout process
         */
        Route::post('/logout', [AuthController::class, 'logout'])->name('ketua.logout');
    }
);
