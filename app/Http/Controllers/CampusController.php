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
        $campus = DB::select("CALL sp_getall_campus");
        return view('/campus/index', compact('campus'));
    }

    public function create()
    {
        $campus = DB::select("CALL sp_getall_campus();");
        return view('campus/create', compact('campus'));
    }

    public function store(Request $request)
    {
        $resultado = DB::update("CALL sp_create_campus( ?, ?, ?, ? );",
            array(
                $request->pNombre,
                $request->pSede,
                $request->pDireccion,
                $request->pTelefono,
            )
        );
        return redirect()->route('campus')->with('primary', 'Campus almacenado satisfactoriamente');
    }

    public function edit($idCampus)
    {
        
        $intid = intval($idCampus);
        $campus = DB::select("CALL sp_get_campus_by_id( $intid );");

        return view('/campus/edit', compact("campus", "intid"));
    }

    public function update(Request $request,$idCampus)
    {
        $resultado = DB::update(
            'CALL sp_edit_campus( ?, ?, ?, ?, ? );',
            array(
                $idCampus,
                $request->pNombre,
                $request->pSede,
                $request->pDireccion,
                $request->pTelefono,
            )
        );
        return redirect()->route('campus')->with('success', 'Campus actalizado satisfactoriamente');
    }

    public function eliminar($idCampus)
    {

        $intid = intval($idCampus);
        $campus = DB::select("CALL sp_get_campus_by_id( $intid );");

        return view('/campus/delete', compact("campus", "intid"));
    }

    public function delete(Request $request, $idCampus)
    {

        $resultado = DB::update('CALL sp_delete_campus( ? )',
            
            array(
                $idCampus,
            )

        );
        return redirect()->route('campus')->with('danger', 'Campus eliminado satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($idCampus)
    {

        $intid = intval($idCampus);
        $campus = DB::select("CALL sp_get_campus_by_id( $intid );");

        return view('/campus/details', compact("campus", "intid"));
    }
}
