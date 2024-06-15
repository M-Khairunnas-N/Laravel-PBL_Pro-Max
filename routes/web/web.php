<?php

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
/**
 * Routes for non-authenticate user
 */
require __DIR__ . '/auth.php';

/**
 * Group route for authenticate user
 */
    /**
    * User Admin
    */
    require __DIR__ . '/admin.php';

    /**
    * User Kader
    */
    require __DIR__ . '/kader.php';

    /**
    * User Ketua
    */
    require __DIR__ . '/ketua.php';