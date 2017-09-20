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

Route::get('/', 'ArticleController@store');

Route::get('/dashboard', 'ArticleController@show');

Route::delete('/dashboard/delete/{id}', 'ArticleController@destroy');
Route::get('/dashboard/edit/{id}', 'ArticleController@edit');
Route::patch('/dashboard/update/{id}', 'ArticleController@update');