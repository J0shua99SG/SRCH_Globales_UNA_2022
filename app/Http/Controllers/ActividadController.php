<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class ActividadController extends Controller
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
        $actividades = DB::select("call sp_getall_tabla_actividad");
        return view('/actividad/index', compact('actividades'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_actividad(?,?,?)',array($request->pTipoActividad, $request->pNombre,$request->pDescripcion));

        return response()->json(['success'=>'Actividad registrada!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_actividad(?,?,?,?)',array($request->pIdActividad,$request->pTipoActividad, $request->pNombre,$request->pDescripcion));

        return response()->json(['success'=>'Actividad actualizada satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_actividad(?)',array($request->IdActividad));

        return response()->json(['success'=>'Actividad eliminada satisfactoriamente!']);
    }

}

