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

Route::get('validate_token', function () {
    return ['message' => 'true'];
})->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\Auth\AuthController@register');
Route::post('login', 'Api\Auth\AuthController@login');

Route::group(['prefix' => 'users'], function () {
    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('detail/{id}', 'Api\Profile\UserProfileController@getUserDetail');
        Route::post('edit/user', 'Api\Profile\UserProfileController@edit');

    });
});

Route::group(['prefix' => 'task'], function () {
    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('get_all_task', 'Api\Task\TaskController@getAllTask');
        Route::post('add_task', 'Api\Task\TaskController@store');
        Route::post('update_task', 'Api\Task\TaskController@update');
        Route::post('delete_task', 'Api\Task\TaskController@destroy');

    });
});

