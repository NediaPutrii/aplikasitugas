<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/home','App\Http\Controllers\HomeController@index')->name('home');
Route::get('/tugaskuindex', 'App\Http\Controllers\TugaskuController@index')->name('tugaskuindex');
Route::get('/tugaskucreate', 'App\Http\Controllers\TugaskuController@create')->name('tugaskucreate');
Route::post('/tugaskustore', 'App\Http\Controllers\TugaskuController@store')->name('tugaskustore');
Route::get('/tugaskushow/{id}','App\Http\Controllers\TugaskuController@show')->name('tugaskushow');
Route::get('/tugaskuedit/{id}','App\Http\Controllers\TugaskuController@edit')->name('tugaskuedit');
Route::put('/tugaskuupdate/{id}','App\Http\Controllers\TugaskuController@update')->name('tugaskuupdate');
Route::delete('/tugaskudestroy/{id}','App\Http\Controllers\TugaskuController@destroy')->name('tugaskudestroy');



