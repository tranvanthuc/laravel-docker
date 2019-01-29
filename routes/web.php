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

Route::get('/', 'ArticleController@index');
Route::get('/search', 'ArticleController@search');
Route::get('create', 'ArticleController@getCreate')->name('create.get');
Route::post('create', 'ArticleController@postCreate')->name('create.post');
Route::get('edit/{id}', 'ArticleController@getEdit')->name('edit.get');
Route::post('edit/{id}', 'ArticleController@postEdit')->name('edit.post');
