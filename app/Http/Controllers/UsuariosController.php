<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UsuariosController extends Controller
{


    public function index()
    {
        $usuarios = DB::select("call sp_getall_tabla_usuario");
        return view('/usuarios/index', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        DB::select('call sp_create_usuario(?,?,?,?,?,?,?,?)',array($request->pTipoUsuario, $request->pDNI , $request->pNombre , $request->pApe1 , $request->pApe2 , $request->pEmailInst , $request->pTelefono , $request->pfecha_Nac));

        return response()->json(['success'=>'Usuario registrado satisfactoriamente!']);
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
        DB::select('call sp_edit_usuario(?,?,?,?,?,?,?,?,?)',array($request->pIdUsuario, $request->pTipoUsuario, $request->pDNI , $request->pNombre , $request->pApe1 , $request->pApe2 , $request->pEmailInst , $request->pTelefono , $request->pfecha_Nac));

        return response()->json(['success'=>'Usuario actalizado satisfactoriamente!']);

    }


    public function delete(Request $request)
    {

        DB::select('call sp_delete_usuario(?)',array($request->pIdUsuario));

        return response()->json(['success'=>'Usuario eliminado exitosamente!']);
    }
}