<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\User\Http\Controllers\UserController;

Route::name('user.')->group(function() {
    Route::get('/login', 'UserController@login')->name('get_login');
    Route::post('/login', 'UserController@attempLogin')->name('post_login');
});
