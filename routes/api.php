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

    Route::get('applications', 'ApplicationsController@index');
    Route::get('dashboard', 'DashboardController@index');
    Route::put('dashboard', 'DashboardController@add');
    Route::delete('dashboard/{id}', 'DashboardController@remove');

    Route::get('friends', 'FriendsController@index');
    Route::get('friendsPending', 'FriendsController@pending');
    Route::put('friends', 'FriendsController@add');
    Route::post('friendConfirm', 'FriendsController@confirm');

    Route::post('search', 'FriendsController@search');
});
