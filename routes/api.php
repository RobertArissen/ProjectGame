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


/* Auth Api's */
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/user', 'API\UserController@index');
    Route::get('/user/buildings', 'API\UserController@buildings');
    Route::post('/user/buildings/buy', 'API\UserController@buyBuilding');

    Route::get('/period/{id}', 'API\PeriodController@byId');

    Route::get('/building', 'API\BuildingController@index');
    Route::get('/building/all', 'API\BuildingController@all');
    Route::get('/question', 'API\QuestionController@unansweredByUser');
    Route::post('/question/answer', 'API\QuestionController@answer');
    Route::get('/question/{questionId}/answer', 'API\QuestionController@getAnswer');
});


/* Classes Api */
Route::get('/class', 'API\ClassController@index');
Route::post('/class/users', 'API\ClassController@getUsers');
Route::post('/class/leaderboard', 'API\ClassController@getLeaderBoard');
