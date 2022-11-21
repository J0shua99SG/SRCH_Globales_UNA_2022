<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
      public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {;
        $totalusuario = DB::select("select count(tabla_usuario.IdUsuario) as totalUsuario from dbglobal.tabla_usuario");
        $totalcampus = DB::select("select count(tabla_campus.IdCampus) as totalCampus from dbglobal.tabla_campus");
        $totalhorario = DB::select("select count(tabla_horario.IdHorario) as totalHorario from dbglobal.tabla_horario");
        $totalactividades = DB::select("select count(tabla_actividad.IdActividad) as totalAct from dbglobal.tabla_actividad");
       // dd($totalusuario);
        return view('/pages/dashboard', compact('totalusuario', 'totalcampus', 'totalhorario', 'totalactividades'));
    }





}
