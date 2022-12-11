<?php

use App\Http\Controllers\FileCdnController;
use Illuminate\Support\Facades\Route;

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

Route::controller(FileCdnController::class)->prefix('/cdn')->name('cdn.')->group(function() {
    Route::get('/user/avatar/{fileName}', 'getUserAvatar')->name('user_avatar');
    Route::get('/user/background/{fileName}', 'getUserBackground')->name('user_background');
});