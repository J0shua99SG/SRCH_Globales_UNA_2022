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


//ROUTE DEPARTAMENTOS
Route::get('/departamentos', 'App\Controllers\DepartamentosController@index')->name('departamentos');

Route::get('/departamentos/create', 'App\Controllers\DepartamentosController@create')->name('departamentos.create');
Route::post('/departamentos/guardar', 'App\Controllers\DepartamentosController@store')->name('departamentos.guardar');
Route::get('/departamentos/details{idDepartamento}', 'App\Controllers\DepartamentosController@details')->name('departamentos.details');
Route::get('/departamentos/{idDepartamento}', 'App\Controllers\DepartamentosController@edit')->name('departamentos.edit');
Route::post('/departamentos/update{idDepartamento}', 'App\Controllers\DepartamentosController@update')->name('departamentos.update');
Route::get('/departamentos/eliminar{idDepartamento}', 'App\Controllers\DepartamentosController@eliminar')->name('departamentos.eliminar');
Route::post('/departamentos/eliminar/delete:{idDepartamento}', 'App\Controllers\DepartamentosController@delete')->name('departamentos.delete');


Route::get('/', function () {
    return view('welcome');
});
