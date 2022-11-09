<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class TipoEspacioController extends Controller
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
        $tipoespacios = DB::select("call sp_getall_tipo_espacio");
        return view('/tipoespacios/index', compact('tipoespacios'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_tipo_espacio(?,?)',array($request->pNombre,$request->pDescripcion));

        return response()->json(['success'=>'Tipo Espacio registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_tipo_espacio(?,?,?)',array($request->pIdTipoEspacio ,$request->pNombre, $request->pDescripcion));

        return response()->json(['success'=>'Tipo Espacio actalizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_tipo_espacio(?)',array($request->pIdTipoEspacio));

        return response()->json(['success'=>'Tipo Espacio eliminado satisfactoriamente!']);
    }

}

