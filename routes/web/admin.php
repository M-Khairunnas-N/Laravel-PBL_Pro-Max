<?php

use App\Http\Controllers\Admin\BantuanController;
use App\Http\Controllers\Admin\KriteriaResource;
use App\Http\Controllers\Admin\PendudukResource;
use App\Http\Controllers\Admin\UserResource;
use App\Http\Controllers\Shared\AuthController;
use App\Http\Controllers\Shared\DashboardController;
use App\Http\Controllers\Shared\ProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web for admin role
|--------------------------------------------------------------------------
|
| we separate web route for role admin to make web routes in web.php more
| clean and easy to maintain admin route in here
|
*/

Route::group(
    [
        'middleware' => ['auth', 'checkLevel:admin'],
        'prefix' => 'admin'
    ],
    function () {
        /**
         * route for fallback kader routes
         */
        Route::fallback(function () {
            return view('404');
        });

        /**
         * routes for dashsboard and profile ketua
         */
        Route::get('/', [DashboardController::class, 'indexAdmin']);
        Route::get('/profile', [ProfileController::class, 'indexAdmin'])->name('admin.profile');
        Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('/foto/{id}/{updated_at}', [ProfileController::class, 'delete'])->name('admin.foto.delete');

        /**
         * routes for data penduduk feature in admin
         */
        Route::resource('penduduk', PendudukResource::class);
        /**
         * routes for data user feature in admin
         */
        Route::resource('user', UserResource::class);

        /**
         * routes for bantuan feature in admin
         */
        Route::resource('kriteria', KriteriaResource::class);
        /**
         * routes for bantuan feature in admin
         */
        Route::group(['prefix' => 'bantuan'], function () {
            // Route::get('/', [BantuanController::class, 'index']);
            // Route::get('/create', [BantuanController::class, 'createKriteria'])->name('kriteria.create');
            // Route::get('/{kode}', [BantuanController::class, 'detailKriteria'])->name('kriteria.detail');
            // Route::post('/', [BantuanController::class, 'storeKriteria'])->name('kriteria.store');
            // Route::get('/{kode}/edit', [BantuanController::class, 'editKriteria'])->name('kriteria.edit');
            // Route::post('/{id}', [BantuanController::class, 'updateKriteria'])->name('kriteria.update');
            // Route::delete('/{kode}', [BantuanController::class, 'destroyKriteria'])->name('kriteria.destroy');
            Route::get('/alternatif', [BantuanController::class, 'alternatif'])->name('bantuan.alternatif');
            Route::post('/saw', [BantuanController::class, 'saw'])->name('bantuan.saw');
            Route::post('/mabac', [BantuanController::class, 'mabac'])->name('bantuan.mabac');
            Route::fallback(function () {
                return redirect()->intended('admin/kriteria');
            });
        });

        /**
         * route for logout process
         */
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    }
);
