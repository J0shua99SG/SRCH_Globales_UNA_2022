@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Departamentos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearCampus"><i
                            class="fas fa-plus"></i>Agregar Departamento</button></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Departamento</th>
                            <th>Nombre</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departamento as $departamentos)
                            <tr id="row-{{ $departamentos->IdDepartamento }}">
                                <td id="id">{{ $departamentos->IdDepartamento }}</td>
                                <td id="Nombre">{{ $departamentos->Nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                        onclick="modalActualizar({{ $departamentos->IdDepartamento }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                        onclick="eliminar({{ $departamentos->IdDepartamento }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $departamentos->IdDepartamento }})"><i
                                            class="fas
                                        fa-eye"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
