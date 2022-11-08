<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TipoActivosController extends Controller
{
    public function index()
    {
        $tipoactivos = DB::select("call sp_getall_tipo_activo");
        return view('/tipoactivos/index', compact('tipoactivos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        DB::select('call sp_create_tipo_activo(?,?)',array($request->pNombre, $request->pDescripcion));

        return response()->json(['success'=>'Tipo de activo registrado satisfactoriamente!']);
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
        DB::select('call sp_edit_tipo_activo(?,?,?)',array($request->pIdTipoActivo, $request->pNombre, $request->pDescripcion));

        return response()->json(['success'=>'Tipo de activo actalizado satisfactoriamente!']);

    }


    public function delete(Request $request)
    {

        DB::select('call sp_delete_tipo_activo(?)',array($request->pIdTipoActivo));

        return response()->json(['success'=>'Tipo de activo eliminado exitosamente!']);
    }
}