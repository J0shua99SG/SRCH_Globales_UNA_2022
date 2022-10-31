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

//ROUTE CAMPUS
Route::get('/campus', 'App\Controllers\CampusController@index')->name('campus');
Route::get('/campus/create', 'App\Controllers\CampusController@create')->name('campus.create');
Route::post('/campus/guardar', 'App\Controllers\CampusController@store')->name('campus.guardar');
Route::get('/campus/details{idCampus}', 'App\Controllers\CampusController@details')->name('campus.details');
Route::get('/campus/{idCampus}', 'App\Controllers\CampusController@edit')->name('campus.edit');
Route::post('/campus/update{idCampus}', 'App\Controllers\CampusController@update')->name('campus.update');
Route::get('/campus/eliminar{idCampus}', 'App\Controllers\CampusController@eliminar')->name('campus.eliminar');
Route::post('/campus/eliminar/delete:{idCampus}', 'App\Controllers\CampusController@delete')->name('campus.delete');

Route::get('/', function () {
    return view('welcome');
});
