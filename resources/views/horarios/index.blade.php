@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Horarios</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearCampus"><i
                            class="fas fa-plus"></i>Agregar Horario</button></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Horario</th>
                            <th>Hora Inicio</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horario as $horarios)
                            <tr id="row-{{ $horarios->IdHorario }}">
                                <td id="id">{{ $horarios->IdHorario }}</td>
                                <td id="Nombre">{{ $horarios->HoraInicio }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                        onclick="modalActualizar({{ $horarios->IdHorario }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                        onclick="eliminar({{ $horarios->IdHorario }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $horarios->IdHorario }})"><i
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
