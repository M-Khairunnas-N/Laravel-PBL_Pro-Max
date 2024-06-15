<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Kader\ArtikelResource;
use App\Http\Controllers\Kader\BayiResource;
use App\Http\Controllers\Kader\InformasiController;
use App\Http\Controllers\Kader\KegiatanResource;
use App\Http\Controllers\Kader\LansiaResource;
use App\Http\Controllers\Shared\AuthController;
use App\Http\Controllers\Shared\DashboardController;
use App\Http\Controllers\Shared\ProfileController;

/*
|--------------------------------------------------------------------------
| Web for kader role
|--------------------------------------------------------------------------
|
| we separate web route for role kader to make web routes in web.php more
| clean and easy to maintain kader route in here
|
*/
Route::group([
    'middleware' => ['auth', 'checkLevel:kader'],
    'prefix' => 'kader'
    ], function () {
        /**
         * route for fallback kader routes
         */
        Route::fallback(function () {
            return view('404');
        });

        /**
         * routes for dashsboard and profile kader
         */
        Route::get('/', [DashboardController::class, 'indexKader'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'indexKader'])->name('kader.profile');
        Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('kader.profile.update');
        Route::get('/foto/{id}/{updated_at}', [ProfileController::class, 'delete'])->name('kader.foto.delete');

        /**
         * routes for pemeriksaan bayi and pemeriksaan lansia feature
         */
        Route::resource('bayi', BayiResource::class);
        Route::resource('lansia', LansiaResource::class);

        /**
         * routes for informasi feature
         */
        Route::group(['prefix' => 'informasi'], function () {
            Route::get('/', InformasiController::class);
            Route::resource('kegiatan', KegiatanResource::class)->except('show');
            Route::resource('artikel', ArtikelResource::class);
        });

        /**
         * route for logout process
         */
        Route::post('/logout', [AuthController::class, 'logout'])->name('kader.logout');
    }
);
