<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.api')->group(function() {
    Route::get('/user', 'UserController@getUserInformation'); 
    Route::post('/logout', 'UserController@logout');
    Route::post('/ckfinder/upload', 'CKFinderController@upload');
    Route::post('/post/create', 'PostController@create');
});

Route::post('/user/facebook_login', 'FacebookController@fbLogin');
Route::get('/post/list', 'PostController@getPosts');