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



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'ArticleController@index');
    Route::get('/search', 'ArticleController@search')->name('search');
    Route::get('create', 'ArticleController@getCreate')->name('create.get');
    Route::post('create', 'ArticleController@postCreate')->name('create.post');
    Route::get('edit/{id}', 'ArticleController@getEdit')->name('edit.get');
    Route::post('edit/{id}', 'ArticleController@postEdit')->name('edit.post');
    Route::get('/messages', 'MessageController@post');
    Route::get('users', 'UsersController@index')->name('users');
    Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
    Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');
    Route::get('/notifications', 'UsersController@notifications');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
