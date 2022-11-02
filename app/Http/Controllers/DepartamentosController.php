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
        $departamento = DB::select("exec sp_getall_departamento");
        return view('/departamento/index', compact('departamento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DB::select("exec sp_getall_departamento");
        return view('departamentos/create', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $resultado = DB::update(
            'exec sp_create_departamento ?',
            array(
                $request->pNombre,
            )
        );
        return redirect()->route('departamentos')->with('primary', 'Departamento almacenado satisfactoriamente');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($idDepartamento)
    {
        $intid = intval($idDepartamento);
        $departamentos = DB::select("exec [sp_get_departamento_by_id] $intid");
        return view('/departamentos/edit', compact("departamentos", "intid"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $idDepartamento)
    {
        $resultado = DB::update(
            'exec sp_edit_departemento ?',
            array(
                $idDepartamento,
                $request->pNombre,
            )
        );
        return redirect()->route('departamentos')->with('success', 'Departamento actalizado satisfactoriamente');
    }


    public function eliminar($idDepartamento)
    {

        $intid = intval($idDepartamento);
        $departamentos = DB::select("exec [sp_get_departamento_by_id] $intid");

        return view('/departamentos/delete', compact("departamentos", "intid"));
    }

    public function delete(Request $request, $idDepartamento)
    {
        $resultado = DB::update(
            'exec sp_delete_departamento ?',
            array(
                $idDepartamento,
            )
        );
        return redirect()->route('departamentos')->with('danger', 'Departamento eliminado con exito');
    }

    public function details($idDepartamento)
    {
        $intid = intval($idDepartamento);
        $campus = DB::select("exec [sp_get_departamento_by_id] $intid");

        
        return view('/departamentos/details', compact("departamentos", "intid"));
    }





   
}
