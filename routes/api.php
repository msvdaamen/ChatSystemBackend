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
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::post('register', 'Auth\RegisterController@register')->name('auth.register');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.name');
    Route::get('me', 'Auth\LoginController@me')->name('auth.me');
});
