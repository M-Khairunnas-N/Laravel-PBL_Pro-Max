<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/lansia/search', [\App\Http\Controllers\Api\SearchController::class, 'searchLansia']);
Route::get('/bayi/search', [\App\Http\Controllers\Api\SearchController::class, 'searchBayi']);
Route::get('/penduduk/search', [\App\Http\Controllers\Api\SearchController::class, 'searchPenduduk']);