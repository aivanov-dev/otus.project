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

Route::namespace('App\Http\Controllers\Api')->group(function () {

    Route::prefix('achievements')->group(function () {
        Route::get('/index', 'AchievementController@index');
        Route::post('/', 'AchievementController@store');
        Route::put('/{achievement}', 'AchievementController@update');
        Route::delete('/{achievement}', 'AchievementController@destroy');
    });

    Route::prefix('results')->group(function () {
        Route::get('/index', 'TaskResultController@index');
        Route::post('/', 'TaskResultController@store');
        Route::put('/{result}', 'TaskResultController@update');
        Route::delete('/{result}', 'TaskResultController@destroy');
    });
});
