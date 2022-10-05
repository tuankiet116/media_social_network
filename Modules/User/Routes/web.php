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

Route::middleware('guest:sanctum')->name('user.')->group(function() {
    Route::get('/login', 'UserController@login')->name('get_login');
    Route::post('/login', 'UserController@attempLogin')->name('post_login');

    Route::get('/forgot', 'UserContrller@forgotPassword')->name('get_forgot_password');
    Route::post('/forgot', 'UserContrller@forgotPassword')->name('post_forgot_password');

    Route::get('/register', 'UserController@login')->name('get_register');
    Route::post('/register', 'UserController@login')->name('post_register');
});

Route::get('/', function() {
    return view('user::home');
})->name('home');
