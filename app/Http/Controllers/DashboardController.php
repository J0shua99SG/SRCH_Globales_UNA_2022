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
        $total = DB::select("select count(tabla_actividad.IdActividad) as totalActividad from dbglobal.tabla_actividad");
        $totalusuario = DB::select("select count(tabla_usuario.IdUsuario) as totalUsuario from dbglobal.tabla_usuario");
       // dd($totalusuario);
        return view('/pages/dashboard', compact('total', 'totalusuario'));
    }





}
