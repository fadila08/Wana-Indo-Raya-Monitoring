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

//untuk menampilkan data (semua)
Route::get('show', 'DataController@get')->name('show');

//untuk menampilkan data (satu data terbaru)
Route::get('showLatest', 'DataController@getLatest')->name('showLatest');

//untuk menampilkan data (10 data waktu terbaru)
Route::get('showWaktu10', 'DataController@getTenLastWaktu')->name('showWaktu10');

//untuk menampilkan data (10 data level air terbaru)
Route::get('showLevel10', 'DataController@getTenLastLevel')->name('showLevel10');

//untuk menyimpan data
Route::post('sendData', 'DataController@post')->name('sendData');

Route::post('update', 'DataController@update')->name('update');