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
Route::get('/info', function(){ phpinfo(); });
Route::middleware('guest:web')->name('user.')->prefix('user')->group(function() {
    Route::get('/login', 'UserController@login')->name('get_login');
    Route::post('/login', 'UserController@attempLogin')->name('post_login');

    Route::get('/forgot', 'UserController@forgotPassword')->name('get_forgot_password');
    Route::post('/forgot', 'UserController@forgotPassword')->name('post_forgot_password');

    Route::get('/register', 'UserController@showFormRegister')->name('get_register');
    Route::post('/register', 'UserController@register')->name('post_register');

    Route::post('/setting_account', 'UserController@settingRegister')->name('post_setting');
});
Route::get('user/setting_account/{tokenRegister?}', 'UserController@showSettingRegister')->name('user.get_setting');

Route::get('/{vue_capture?}', function() {
    return view('user::home');
})->name('home');

Route::get('{any}', function () {
    return view('user::home');
})->where('any', '.*');

// Route::get('/{vue_capture?}', function() {
//     return view('user::home');
// })->where('vue_capture',  '^(?!api)(?!user)(?!info)(?!public).*$')->name('home');