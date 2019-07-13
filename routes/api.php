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
Route::get('show', 'DataController@get');

//untuk menampilkan data (satu data terbaru)
Route::get('showLatest', 'DataController@getLatest');

//untuk menampilkan data (10 data waktu terbaru)
Route::get('showWaktu10', 'DataController@getTenLastWaktu');

//untuk menampilkan data (10 data level air terbaru)
Route::get('showLevel10', 'DataController@getTenLastLevel');

//untuk menyimpan data
Route::post('sendData', 'DataController@post');