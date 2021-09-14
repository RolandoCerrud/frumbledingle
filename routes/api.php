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

Route::resource('locations', 'Api\LocationController', ['only' => ['index', 'store', 'destroy','update']]);
Route::resource('items', 'Api\ItemController', ['only' => ['index', 'store', 'destroy','update']]);
Route::resource('categories', 'Api\CategoriesController', ['only' => ['index', 'store', 'destroy','update']]);
Route::any('report', 'Api\ReportController@index');

