<?php

use Illuminate\Support\Facades\Route;

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




Route::get('/index', 'App\Http\Controllers\CalendarController@index');
Route::post('/store', 'App\Http\Controllers\CalendarController@store');



Route::get('/', function () {
    return view('welcome');
});
