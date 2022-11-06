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
Route::get('/departamentos', [DepartamentosController::class, 'index'])->name('departamentos.index');
Route::post('/departamentos/guardar', [DepartamentosController::class, 'store'])->name('departamentos.guardar');
Route::post('/departamentos/update', [DepartamentosController::class, 'update'])->name('departamentos.update');
Route::post('/departamentos/delete', [DepartamentosController::class, 'delete'])->name('departamentos.delete');


//ROUTE HORARIOS
Route::get('/horarios', [HorariosController::class, 'index'])->name('horarios.index');
Route::post('/horarios/guardar', [HorariosController::class, 'store'])->name('horarios.guardar');
Route::post('/horarios/update', [HorariosController::class, 'update'])->name('horarios.update');
Route::post('/horarios/delete', [HorariosController::class, 'delete'])->name('horarios.delete');


Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/registro', function () {
    return view('login.registro');
});

Route::get('/login', function () {
    return view('login.sesion');
});
