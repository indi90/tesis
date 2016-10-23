<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::resource('calculate', 'CalculateController', ['only' => ['index', 'store']]);
    Route::get('history', 'HistoryController@index');

    Route::get('dashboard', 'DashboardController@index');
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('retails', 'RetailController', ['except' => ['show']]);
        Route::resource('users', 'UserController', ['except' => ['show']]);
        Route::resource('calculate_values', 'CalculateValueController', ['only' => ['index', 'edit', 'update']]);

        Route::post('retails/multiple_delete', [
            'as'    => 'retails.multiple_delete',
            'uses'  => 'RetailController@multiple_delete'
        ]);
    });
});
