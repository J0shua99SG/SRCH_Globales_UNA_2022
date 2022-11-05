<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\HorariosController;

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
Route::get('/campus', [CampusController::class, 'index'])->name('campus.index');
Route::post('/campus/guardar', [CampusController::class, 'store'])->name('campus.guardar');
Route::post('/campus/update', [CampusController::class, 'update'])->name('campus.update');
Route::post('/campus/delete', [CampusController::class, 'delete'])->name('campus.delete');





//ROUTE DEPARTAMENTOS
Route::get('/departamentos', 'App\Controllers\DepartamentosController@index')->name('departamentos');

Route::get('/departamentos/create', 'App\Controllers\DepartamentosController@create')->name('departamentos.create');
Route::post('/departamentos/guardar', 'App\Controllers\DepartamentosController@store')->name('departamentos.guardar');
Route::get('/departamentos/details{idDepartamento}', 'App\Controllers\DepartamentosController@details')->name('departamentos.details');
Route::get('/departamentos/{idDepartamento}', 'App\Controllers\DepartamentosController@edit')->name('departamentos.edit');
Route::post('/departamentos/update{idDepartamento}', 'App\Controllers\DepartamentosController@update')->name('departamentos.update');
Route::get('/departamentos/eliminar{idDepartamento}', 'App\Controllers\DepartamentosController@eliminar')->name('departamentos.eliminar');
Route::post('/departamentos/eliminar/delete:{idDepartamento}', 'App\Controllers\DepartamentosController@delete')->name('departamentos.delete');


//ROUTE HORARIOS
Route::get('/horarios', 'App\Controllers\HorariosController@index')->name('horarios');
Route::get('/horarios/create', 'App\Controllers\HorariosController@create')->name('horarios.create');
Route::post('/horarios/guardar', 'App\Controllers\HorariosController@store')->name('horarios.guardar');
Route::get('/horarios/details{idHorario}', 'App\Controllers\HorariosController@show')->name('horarios.show');
Route::get('/horarios/{idHorario}', 'App\Controllers\HorariosController@edit')->name('horarios.edit');
Route::post('/horarioscampus/update{idHorario}', 'App\Controllers\HorariosController@update')->name('horarios.update');
Route::get('/horarios/eliminar{idHorario}', 'App\Controllers\HorariosController@eliminar')->name('horarios.eliminar');
Route::post('/horarios/eliminar/delete:{idHorario}', 'App\Controllers\HorariosController@delete')->name('horarios.delete');

Route::get('/', function () {
    return view('layout.master');
});
