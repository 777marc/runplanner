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

Route::middleware('api')->prefix('auth')->group(function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
});

Route::middleware('auth')->group(function () {
    // workout
    Route::get('/workouts', 'WorkoutController@index');
    Route::get('/workouts/{id}', 'WorkoutController@show');
    Route::post('/workouts', 'WorkoutController@store');
    Route::put('/workouts/{id}', 'WorkoutController@update');
    Route::delete('/workouts/{id}', 'WorkoutController@destroy');

    // training schedule
    Route::get('/trainingschedules', 'TrainingScheduleController@index');
    Route::post('/trainingschedules', 'TrainingScheduleController@store');
    Route::put('/trainingschedules/{id}', 'TrainingScheduleController@update');
    Route::delete('/trainingschedules/{id}', 'TrainingScheduleController@destroy');

    // training plan
    Route::get('/trainingplans', 'TrainingPlanController@index');

});
