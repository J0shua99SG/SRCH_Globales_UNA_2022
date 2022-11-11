<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class EspacioController extends Controller
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
        $espacios = DB::select("call sp_getall_espacio");
        $edificios = DB::select("call sp_getall_edificio");
        $tipoespacios = DB::select("call sp_getall_tipo_espacio");
        $departamento = DB::select("call sp_getall_departamento");

        return view('/espacios/index', compact('espacios','edificios','tipoespacios','departamento'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_espacio(?,?,?,?,?,?,?)',
            array($request->pIdEdificio,$request->pIdTipoEspacio,$request->pIdDepartamento,$request->pNombre,
                   $request->pPlanta,$request->pCapacidadMax,$request->pEstadoEspacio));
                        
        return response()->json(['success'=>'Espacio registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_espacio(?,?,?,?,?,?,?,?)',
            array($request->pIdEspacio,$request->pIdEdificio,$request->pIdTipoEspacio,
                  $request->pIdDepartamento,$request->pNombre,
                  $request->pPlanta,$request->pCapacidadMax,
                  $request->pEstadoEspacio));

        return response()->json(['success'=>'Espacio actalizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_espacio(?)',array($request->pIdEspacio));

        return response()->json(['success'=>'Espacio eliminado satisfactoriamente!']);
    }

}

