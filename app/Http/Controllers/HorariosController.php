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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idHorario)
    {
        $horarios = DB::select('CALL sp_get_horario_by_id ?', array($idHorario));
        return view('/horarios/details', compact("horario"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idHorario)
    {
        $horarios = DB::select('CALL sp_get_horario_by_id ?', array($idHorario));
        return view('/horarios/edit', compact("horario"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idHorario)
    {
        $request = DB::update('CALL sp_update_horario ?,?,?,?,?,?,?,?,?', array(
            $request->pIdUsuario,
            $request->pIdActividad,
            $request->pIdEspacio,
            $request->pHoraInicio,
            $request->pHoraFinalizacion,
            $request->pFechaInicio,
            $request->pFechaFin,
            $request->pDia,
            $request->pEstado,
            $request->pFechaActivacion,
        ));
        return redirect()->route('horarios')->with('primary', 'Horario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function eliminar($idHorario)
    {
        $horarios = DB::select('CALL sp_get_horario_by_id ?', array($idHorario));
        return view('/horarios/delete', compact("horario"));
    }
     
    public function delete(Request $request, $idHorario)
    {
        $request = DB::delete('CALL sp_delete_horario ?', array($idHorario));
        return redirect()->route('horarios')->with('primary', 'Horario eliminado correctamente');
    }
}