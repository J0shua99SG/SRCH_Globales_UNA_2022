<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $horario = DB::select("call sp_getall_horario");

        $actividad = DB::select("call sp_getall_tabla_actividad");

        $espacio = DB::select("call sp_getall_espacio");

        $usuario = DB::select("call sp_getall_tabla_usuario");
        
        return view('/horarios/index', compact('horario','actividad', 'espacio', 'usuario'));

    }
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::select('call sp_create_horario(?,?,?,?,?,?,?,?,?,?)',array($request->pIdUsuario,$request->pIdActividad,$request->pIdEspacio,$request->pHoraInicio,
         $request->pHoraFinalizacion, $request->pFechaInicio, $request->pFechaFin, $request->pDia,$request->pEstado,$request->pFechaActivacion));

        return response()->json(['success'=>'Horario almacenado correctamente!']);
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

        DB::select('call sp_edit_horario(?,?,?,?,?,?,?,?,?,?,?)',array($request->pIdHorario, $request->pIdUsuario,$request->pIdActividad,$request->pIdEspacio,$request->pHoraInicio,
         $request->pHoraFinalizacion, $request->pFechaInicio, $request->pFechaFin, $request->pDia,$request->pEstado,$request->pFechaActivacion));

        return response()->json(['success'=>'Horario actualizado correctamente!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {
        DB::select('call sp_delete_horario(?)',array($request->pIdHorario));

       return response()->json(['success'=>'Horario eliminado correctamente!']);

    }
}