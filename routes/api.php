<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace('Api')->middleware('auth:api')->group(function () {
    Route::get('user', 'LoginController@user');
    Route::get('user/revoke', 'LoginController@revoke');
    Route::get('streams-amount-per-game', 'StreamController@amount');
    Route::get('streams-highest-per-game', 'StreamController@highest');
    Route::get('streams-median', 'StreamController@median');
    Route::get('streams-odd', 'StreamController@odd');
    Route::get('streams-even', 'StreamController@even');
    Route::get('streams-top', 'StreamController@top');
    Route::get('streams-same-amount', 'StreamController@same');
});
