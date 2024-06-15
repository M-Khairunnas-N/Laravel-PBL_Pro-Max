<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/lansia/search', [\App\Http\Controllers\Api\SearchController::class, 'searchLansia']);
Route::get('/bayi/search', [\App\Http\Controllers\Api\SearchController::class, 'searchBayi']);
Route::get('/penduduk/search', [\App\Http\Controllers\Api\SearchController::class, 'searchPenduduk']);
Route::get('/informasi/search', [\App\Http\Controllers\Api\SearchController::class, 'searchInformasi']);
Route::get('/user/search', [\App\Http\Controllers\Api\SearchController::class, 'searchUser']);