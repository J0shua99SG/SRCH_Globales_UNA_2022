<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CampusController extends Controller
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
        $campus = DB::select("call sp_getall_campus");
        return view('/campus/index', compact('campus'));
    }

    public function store(Request $request)
    {
        DB::select('call sp_create_campus(?,?,?,?)',array($request->pNombre,$request->pSede,$request->pDireccion,$request->pTelefono));

        return response()->json(['success'=>'Campus registrado!']);
    }

    public function update(Request $request)
    {
        DB::select('call sp_edit_campus(?,?,?,?,?)',array($request->pIdCampus, $request->pNombre,$request->pSede,$request->pDireccion,$request->pTelefono));

        return response()->json(['success'=>'Campus actalizado satisfactoriamente!']);
    }

    public function delete(Request $request)
    {
        DB::select('call sp_delete_campus(?)',array($request->idCampus));

        return response()->json(['success'=>'Campus eliminado satisfactoriamente!']);
    }

}
