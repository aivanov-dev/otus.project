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
    });

    // Skills and levels
    Route::prefix('/skills')->group(function () {
        Route::get('/', 'SkillController@all');
        Route::post('/', 'SkillController@store');

        Route::prefix('/{id}')->group(function () {
            Route::get('/', 'SkillController@get');
            Route::patch('/', 'SkillController@update');
            Route::delete('/', 'SkillController@delete');
        });

        Route::prefix('/levels')->group(function () {
            Route::get('/all', 'SkillController@getAllLevels');
            Route::get('/search', 'SkillController@getLevelName');
        });
    });

    //Users
    Route::prefix('/users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::get('/{id}', 'UserController@get');
        Route::post('/', 'UserController@store');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@delete');
    });

    //ExerciseGroups
    Route::prefix('/exercise-groups')->group(function () {
        Route::get('/', 'ExerciseGroupsController@all');
        Route::get('/ancestors/{id}', 'ExerciseGroupsController@getAncestors');
        Route::get('/descendants/{id}', 'ExerciseGroupsController@getDescendants');
        Route::post('/', 'ExerciseGroupsController@store');
        Route::delete('/{id}', 'ExerciseGroupsController@delete');
    });

    //Exercises
    Route::prefix('/exercises')->group(function () {
        Route::get('/', 'ExerciseController@index');
        Route::get('/{id}', 'ExerciseController@get');
        Route::post('/', 'ExerciseController@store');
        Route::put('/{id}', 'ExerciseController@update');
        Route::delete('/{id}', 'ExerciseController@delete');
    });

    //Tasks
    Route::prefix('/tasks')->group(function () {
        Route::get('/', 'TaskController@index');
        Route::get('/{id}', 'TaskController@get');
        Route::post('/', 'TaskController@store');
        Route::put('/{id}', 'TaskController@update');
        Route::delete('/{id}', 'TaskController@delete');
    });

    //TaskResultsStatistics
    Route::prefix('result-statistics-tasks')->group(function () {
        Route::get('/', 'TaskResultStatisticsController@index');
        Route::get('/{id}', 'TaskResultStatisticsController@get');
        Route::put('/{id}', 'TaskResultStatisticsController@update');
        Route::delete('/{id}', 'TaskResultStatisticsController@delete');
    });
});

