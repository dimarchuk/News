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


Route::domain('news.com')->group(function () {
    Route::get('{slug}', function () {
        return view('index');
    })->where('slug', '(?!api)([A-z\d-\/_.]+)?');
    Auth::routes();

});


Route::domain('admin.8434-5a79ee928fcb5.st.php-academy.org')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->middleware(['auth', 'admin']);

    Route::get('/addcat', 'Admin\AddCategoriesController@index');
    Route::post('/addcat', 'Admin\AddCategoriesController@add');

    Route::get('/addnews', 'Admin\AddNewsController@index');
    Route::post('/addnews', 'Admin\AddNewsController@add');

    Route::get('/addadvertising', 'Admin\AddAdvertisingController@index');
    Route::post('/addadvertising', 'Admin\AddAdvertisingController@add');

    Route::get('/setbgc', 'Admin\setBGCController@index');
    Route::post('/setbgc', 'Admin\setBGCController@set');

    Route::get('/comments', 'Admin\CommentsController@index');
    Route::get('/approved', 'Admin\ApprovedController@index');
    Route::get('/approve/{id}', 'Admin\ApprovedController@approve');
    Route::get('/update/{id}', 'Admin\UpdateController@index');
    Route::post('/update', 'Admin\UpdateController@update');



    Auth::routes();
});


