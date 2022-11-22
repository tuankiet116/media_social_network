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

Route::get('/ckfinder/get-image/{fileName}', 'CKFinderController@getImage')->name('ckfinder.get_image');
Route::middleware('auth.api')->group(function() {
    Route::get('/user', 'UserController@getUserInformation'); 
    Route::post('/logout', 'UserController@logout');
    Route::post('/ckfinder/upload', 'CKFinderController@uploadImage');
});

Route::middleware('auth.api')->prefix('post')->name('post.')->group(function() {
    Route::post('/create', 'PostController@create')->name('create');
    Route::post('/reaction', 'PostController@reaction')->name('reaction');
    Route::post('/reaction/count', 'PostUserController@getNumberLikePost')->name('reaction.count');
    Route::get('/get/{id}', 'PostController@getPost')->name('get');
    Route::delete('/delete/{postId}', 'PostController@delete')->name('delete');
    Route::put('/update', 'PostController@update')->name('update');
});

Route::middleware('auth.api')->prefix('comment')->name('comment.')->group(function() {
    Route::post('/create', 'CommentController@create')->name('create');
    Route::get('/list/{postId}/{offset?}', 'CommentController@getComments')->name('list');
    Route::delete('/delete/{commentId}', 'CommentController@deleteComment')->name('delete');
    Route::post('/like', 'CommentController@likeComment')->name('like_comment');
    Route::post('/reply', 'CommentController@reply')->name('reply');
    Route::get('/list/reply', 'CommentController@getReplies')->name('get_replies');
    Route::put('/update', 'CommentController@update')->name('update');
});

Route::post('/user/facebook_login', 'FacebookController@fbLogin');
Route::get('/post/list', 'PostController@getPosts');
Route::get('/post/stream/{fileName}', 'PostController@stream');