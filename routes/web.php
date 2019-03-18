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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'ArticleController@index');
    Route::get('/search', 'ArticleController@search')->name('search');
    Route::get('create', 'ArticleController@getCreate')->name('create.get');
    Route::post('create', 'ArticleController@postCreate')->name('create.post');
    Route::get('edit/{id}', 'ArticleController@getEdit')->name('edit.get');
    Route::post('edit/{id}', 'ArticleController@postEdit')->name('edit.post');

    Route::get('users', 'UsersController@index')->name('users');
    Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
    Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');
    Route::get('/notifications', 'UsersController@notifications');
});

Route::get('/firebase', 'FirebaseController@index');
Auth::routes();

Route::prefix('/test')->group(function () {
    Route::get('/', 'TestController@index');
    Route::get('/realtime', 'TestController@realtime');
});

Route::prefix('s3')->group(function () {
   Route::get('/', 'S3Controller@index')->name('s3.index');
   Route::post('/upload', 'S3Controller@upload')->name('s3.upload');
   Route::post('/get', 'S3Controller@upload')->name('s3.get');
});


Route::get('/home', 'HomeController@index')->name('home');
