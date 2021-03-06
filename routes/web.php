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
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::prefix('cars')->group(function (){
        Route::get('/', 'CarController@getCars');
        Route::get('{id}', 'CarController@getOneCar');
    });
    Route::resource('admin/cars', "Admin\\AdminCarController", ['except' => ['create','edit']]);
});
