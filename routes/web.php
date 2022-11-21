<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\EdificiosController;
use App\Http\Controllers\TipoActivosController;
use App\Http\Controllers\TipoEspacioController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\EspacioActivoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DashboardController;




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
//ROUTE CAMPUS listo
Route::get('/campus', [CampusController::class, 'index'])->name('campus.index');
Route::post('/campus/guardar', [CampusController::class, 'store'])->name('campus.guardar');
Route::post('/campus/update', [CampusController::class, 'update'])->name('campus.update');
Route::post('/campus/delete', [CampusController::class, 'delete'])->name('campus.delete');


//ROUTE DEPARTAMENTOS listo
Route::get('/departamentos', [DepartamentosController::class, 'index'])->name('departamentos.index');
Route::post('/departamentos/guardar', [DepartamentosController::class, 'store'])->name('departamentos.guardar');
Route::post('/departamentos/update', [DepartamentosController::class, 'update'])->name('departamentos.update');
Route::post('/departamentos/delete', [DepartamentosController::class, 'delete'])->name('departamentos.delete');


//ROUTE HORARIOS listo
Route::get('/horarios', [HorariosController::class, 'index'])->name('horarios.index');
Route::post('/horarios/guardar', [HorariosController::class, 'store'])->name('horarios.guardar');
Route::post('/horarios/update', [HorariosController::class, 'update'])->name('horarios.update');
Route::post('/horarios/delete', [HorariosController::class, 'delete'])->name('horarios.delete');


//ROUTE TIPO_ACTIVO listo
Route::get('/tipoactivos', [TipoActivosController::class, 'index'])->name('tipoactivos.index');
Route::post('/tipoactivos/guardar', [TipoActivosController::class, 'store'])->name('tipoactivos.guardar');
Route::post('/tipoactivos/update', [TipoActivosController::class, 'update'])->name('tipoactivos.update'); 
Route::post('/tipoactivos/delete', [TipoActivosController::class, 'delete'])->name('tipoactivos.delete');


//ROUTE EDIFICIOS listo
Route::get('/edificios', [EdificiosController::class, 'index'])->name('edificios.index');
Route::post('/edificios/guardar', [EdificiosController::class, 'store'])->name('edificios.guardar');
Route::post('/edificios/update', [EdificiosController::class, 'update'])->name('edificios.update'); 
Route::post('/edificios/delete', [EdificiosController::class, 'delete'])->name('edificios.delete');

//ROUTE TIPOESPACIOS listo
Route::get('/tipoespacios', [TipoEspacioController::class, 'index'])->name('tipoespacios.index');
Route::post('/tipoespacios/guardar', [TipoEspacioController::class, 'store'])->name('tipoespacios.guardar');
Route::post('/tipoespacios/update', [TipoEspacioController::class, 'update'])->name('tipoespacios.update'); 
Route::post('/tipoespacios/delete', [TipoEspacioController::class, 'delete'])->name('tipoespacios.delete');


//ROUTE ESPACIOS listo
Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');
Route::post('/espacios/guardar', [EspacioController::class, 'store'])->name('espacios.guardar');
Route::post('/espacios/update', [EspacioController::class, 'update'])->name('espacios.update'); 
Route::post('/espacios/delete', [EspacioController::class, 'delete'])->name('espacios.delete');

//ROUTE ACTIVIDAD listo
Route::get('/actividad', [ActividadController::class, 'index'])->name('actividad.index');
Route::post('/actividad/guardar', [ActividadController::class, 'store'])->name('actividad.guardar');
Route::post('/actividad/update', [ActividadController::class, 'update'])->name('actividad.update'); 
Route::post('/actividad/delete', [ActividadController::class, 'delete'])->name('actividad.delete');


//ROUTE ACTIVOS listo
Route::get('/activo', [ActivoController::class, 'index'])->name('activo.index');
Route::post('/activo/guardar', [ActivoController::class, 'store'])->name('activo.guardar');
Route::post('/activo/update', [ActivoController::class, 'update'])->name('activo.update'); 
Route::post('/activo/delete', [ActivoController::class, 'delete'])->name('activo.delete');


//ROUTE ESPACIO ACTIVOS
Route::get('/espacioactivos', [EspacioActivoController::class, 'index'])->name('espacioactivos.index');
Route::post('/espacioactivos/guardar', [EspacioActivoController::class, 'store'])->name('espacioactivos.guardar');
Route::post('/espacioactivos/update', [EspacioActivoController::class, 'update'])->name('espacioactivos.update'); 
Route::post('/espacioactivos/delete', [EspacioActivoController::class, 'delete'])->name('espacioactivos.delete');


//ROUTE USUARIOS
Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
Route::post('/usuarios/guardar', [UsuariosController::class, 'store'])->name('usuarios.guardar');
Route::post('/usuarios/update', [UsuariosController::class, 'update'])->name('usuarios.update'); 
Route::post('/usuarios/delete', [UsuariosController::class, 'delete'])->name('usuarios.delete');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/', function () {
    return view('login.sesion');
});

Route::get('/registro', function () {
    return view('login.registro');
});

Route::get('/login', function () {
    return view('login.sesion');
});
