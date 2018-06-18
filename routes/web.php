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

Route::get('/', function () {
    return view('spa');
});

Route::post('auth/login', 'AuthController@login');
Route::post('auth/signup', 'AuthController@signup');
Route::post('auth/forgot-password', 'AuthController@forgotPassword');
Route::get('auth/reset-password', 'AuthController@showResetPasswordForm')->name('password.reset');
Route::post('auth/reset-password', 'AuthController@resetPassword');

Route::get('test', 'TestController@test');

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('auth/session', 'AuthController@userSession');
});

Route::middleware(['jwt.refresh'])->group(function () {
    Route::get('auth/refresh', function () {
        return response(null, 204);
    });
});
