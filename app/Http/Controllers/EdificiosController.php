<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class EdificiosController extends Controller
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
        $edificios = DB::select("call sp_getall_edificio");
        return view('/edificios/index', compact('edificios'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_edificio(?,?)',array($request->pIdCampus,$request->pNombre));

        return response()->json(['success'=>'Edificio registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_edificio(?,?,?)',array($request->pIdEdificio,$request->pIdCampus, $request->pNombre));

        return response()->json(['success'=>'Edificio actalizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_edificio(?)',array($request->pIdEdificio));

        return response()->json(['success'=>'Edificio eliminado satisfactoriamente!']);
    }

}

