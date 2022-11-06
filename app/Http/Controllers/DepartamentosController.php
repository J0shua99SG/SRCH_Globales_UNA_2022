<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamento = DB::select("call sp_getall_departamento");
        return view('/departamentos/index', compact('departamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        DB::select('call sp_create_departamento(?)',array($request->pNombre));

        return response()->json(['success'=>'Departamento almacenado satisfactoriamente!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        DB::select('call sp_edit_departemento(?,?)',array($request->pIdDepartamento, $request->pNombre));

        return response()->json(['success'=>'Departamento actalizado satisfactoriamente!']);

    }


    public function delete(Request $request)
    {

        DB::select('call sp_delete_departamento(?)',array($request->IdDepartamento));

        return response()->json(['success'=>'Departamento eliminado con exito!']);
    }
}
