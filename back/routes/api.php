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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'App\Http\Controllers\API\AuthController@login');
    Route::post('registrarse', 'App\Http\Controllers\API\AuthController@registrarse');
    Route::get('signup/activate/{token}', 'App\Http\Controllers\API\AuthController@signupActivate');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'App\Http\Controllers\API\AuthController@logout');
        Route::get('user', 'App\Http\Controllers\API\AuthController@user');
    });
});

Route::group(['prefix' => 'empleado'], function () {
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('', 'App\Http\Controllers\API\EmpleadoController@store');
        Route::get('showPorUsuario/{idUser}', 'App\Http\Controllers\API\EmpleadoController@showPorUsuario');
        Route::get('', 'App\Http\Controllers\API\EmpleadoController@index');
        Route::put('', 'App\Http\Controllers\API\EmpleadoController@update');
        Route::get('/{id}','App\Http\Controllers\API\EmpleadoController@show');
    });
});




Route::group(['prefix' => 'password'], function () {
    Route::post('create', 'App\Http\Controllers\API\PasswordResetController@create');
    Route::get('find/{token}', 'App\Http\Controllers\API\PasswordResetController@find');
    // Route::get('find/{token}', function () {
    //     return 'Hello World';
    // });
    Route::post('reset', 'App\Http\Controllers\API\PasswordResetController@reset');
});
