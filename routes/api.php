<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::post('logout', 'Auth\LogoutController@logout');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@register');
});

Route::get('/verify/{token}', 'Auth\VerificationController@verify');

Route::group(['middleware' => 'auth.role:Moderator'], function () {
    Route::resource('roles', 'RolesController');
});

Route::group(['middleware' => 'auth.role:HR Manager'], function () {
   Route::resource('job-offers', 'JobOffersController');
});
