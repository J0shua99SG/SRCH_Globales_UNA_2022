<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class ActivoController extends Controller
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
    {
        $activos = DB::select("call sp_getall_tabla_activo");
        return view('/activo/index', compact('activo'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_activo(?,?)',array($request->pIdTipoActivo, $request->pNombre));

        return response()->json(['success'=>'Activo registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_activo(?,?,?)',array($request->pIdActivo,$request->pIdTipoActivo, $request->pNombre));

        return response()->json(['success'=>'Activo actualizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_activo(?)',array($request->pIdActivo));

        return response()->json(['success'=>'Activo eliminado satisfactoriamente!']);
    }

}

