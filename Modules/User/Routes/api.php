<?php

use App\Models\User;
use Illuminate\Http\Request;
use Modules\User\Http\Controllers\UserController;

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
    Route::post('/password/update', 'UserController@updatePassword');
});

Route::middleware('auth.api')->prefix('profile')->name('profile.')->group(function() {
    Route::get('/me', 'UserInformationController@getProfile');
    Route::get('/default/avatar', 'UserInformationController@getListUserImageDefault');
    Route::get('/default/background', 'UserInformationController@getBackgroundDefault');
    Route::post('/follow', 'UserInformationController@followUser');
    Route::post('/unfollow', 'UserInformationController@unfollowUser');
    Route::prefix('update')->name('update.')->group(function() {
        Route::put('/info', 'UserInformationController@updateInformation');
        Route::post('/avatar', 'UserInformationController@updateAvatar');
        Route::post('/background', 'UserInformationController@updateBackground');
    });
});

Route::middleware('auth.api')->prefix('post')->name('post.')->group(function() {
    Route::post('/create', 'PostController@create')->name('create');
    Route::post('/reaction', 'PostController@reaction')->name('reaction');
    Route::post('/reaction/count', 'PostUserController@getNumberLikePost')->name('reaction.count');
    Route::delete('/delete/{postId}', 'PostController@delete')->name('delete');
    Route::put('/update', 'PostController@update')->name('update');
});

Route::middleware('auth.api')->prefix('comment')->name('comment.')->group(function() {
    Route::post('/create', 'CommentController@create')->name('create');
    Route::get('/list/{postId}/{offset?}', 'CommentController@getComments')->name('list');
    Route::delete('/delete/{commentId}', 'CommentController@deleteComment')->name('delete');
    Route::post('/like', 'CommentController@likeComment')->name('like_comment');
    Route::post('/reply', 'CommentController@reply')->name('reply');
    Route::get('/list/{commentId}/reply/{offset?}', 'CommentController@getReplies')->name('get_replies');
    Route::put('/update', 'CommentController@update')->name('update');
});

Route::middleware('auth.api')->prefix('community')->name('community.')->group(function() {
    Route::post('/create', 'CommunityController@createCommunity')->name('create');
    Route::get('/list', 'CommunityController@getListCommunityJoined')->name('list');
    Route::post('/join/{community}', 'CommunityController@joinCommunity')->middleware('can:join,community');
    Route::post('/unjoin/{community}', 'CommunityController@unjoinCommunity')->middleware('can:unjoin,community');
    Route::get('/members/{community}', 'CommunityController@listMembers')->middleware('can:update,community');
    Route::delete('/members/{community}', 'CommunityController@deleteMember')->middleware('can:update,community');
    Route::post('/setting/info/{community}', 'CommunitySettingController@updateInformation')->middleware('can:update,community');
    Route::post('/setting/avatar/{community}', 'CommunitySettingController@updateAvatar')->middleware('can:update,community');
    Route::post('/setting/background/{community}', 'CommunitySettingController@updateBackground')->middleware('can:update,community');
});

Route::prefix('search')->group(function() {
    Route::get('history', 'SearchController@searchHistory');
    Route::get('all', 'SearchController@searchAll');
    Route::get('post', 'SearchController@searchPost');
    Route::get('user', 'SearchController@searchUser');
    Route::get('community', 'SearchController@searchCommunity');
    Route::post('history', 'SearchController@insertHistory');
});

Route::get('community/posts/{id}/{offset?}', 'CommunityController@getPosts')->name('posts');
Route::get('community/info/{id}', 'CommunityController@getInfo')->name('info');

Route::post('/user/facebook_login', 'FacebookController@fbLogin');

Route::get('/post/list/{offset?}/{userId?}', 'PostController@getPosts');
Route::get('/post/stream/{fileName}', 'PostController@stream');
Route::get('/post/get/{id}', 'PostController@getPost')->name('get_post');

Route::get('/profile/info/{id}', 'UserInformationController@getUserProfile');

Route::get('/profile/follower', 'FollowController@getFollower');
Route::get('/profile/following', 'FollowController@getFollowing');
