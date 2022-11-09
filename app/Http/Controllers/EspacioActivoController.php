<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class EspacioActivoController extends Controller
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
        $espacioactivos = DB::select("call sp_getall_espacio_activo");
        return view('/espacioactivos/index', compact('espacioactivos'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_espacio_activo(?,?,?)',array($request->pIdEspacio,$request->pIdActivo,$request->pCantidad));

        return response()->json(['success'=>'Espacio Activo registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_espacio_Activo(?,?,?,?)',array($request->pIdEspacioActivo,$request->pIdEspacio, $request->pIdActivo,$request->pCantidad));

        return response()->json(['success'=>'Espacio Activo actualizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_espacio_Activo(?)',array($request->pIdEspacioActivo));

        return response()->json(['success'=>'Espacio Activoeliminado satisfactoriamente!']);
    }

}

