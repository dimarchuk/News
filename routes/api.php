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

Route::group(['middleware' => ['web']], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['web']], function () {

    Route::get('/index', 'IndexController@index');

    Route::get('/category/{id}', 'CategoryController@index');
    Route::post('/category/{id}', 'CategoryController@index');

    Route::get('/article/{id}', 'ArticleController@index');
    Route::get('/articles', 'ArticleController@all');

    Route::get('/tag/{id}', 'ArticleController@tagArticles');
    Route::get('/tags/{str}', 'ArticleController@searchTags');

    Route::get('/search', 'SearchArticleController@index');
    Route::post('/search', 'SearchArticleController@search');

    Route::get('/advertising', 'AdvertisingController@index');

    Route::get('/bgcolors', 'BGCController@index');

    Route::get('/setnumviews/{newsid}', 'ArticleController@setViews');

    Route::get('/getcomments/{id}', 'CommentsController@index');
    Route::post('/addcomment', 'CommentsController@add');
    Route::get('/active', 'CommentsController@getActiveUsers');
    Route::get('/usercomments/{id}', 'CommentsController@getUserComments');
});