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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/urls', 'App\Http\Controllers\ShortUrlController@store');
Route::get('/urls', 'App\Http\Controllers\ShortUrlController@index');
Route::get('/urls/{token}', 'App\Http\Controllers\ShortUrlController@show');
