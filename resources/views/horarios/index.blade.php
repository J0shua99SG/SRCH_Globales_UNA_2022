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
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearHorario"><i
                                class="fas fa-plus"></i>Agregar Horario</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Horario</th>
                                <th>Usuario</th>
                                <th>actividad</th>
                                <th>Espacios</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Dia</th>
                                <th>Estado</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horario as $horarios)
                                <tr id="row-{{ $horarios->Nombre }}">
                                    <td id="id">{{ $horarios->IdHorario }}</td>
                                    <td id="id">{{ $horarios->Nombre }}</td>
                                    @foreach ($actividad as $actividades)
                                    @if ($horarios->IdActividad == $actividades->IdActividad)
                                    <td id="IdActividad">{{ $actividades->Nombre }}</td>
                                    @endif
                                    @endforeach
                                    @foreach ($espacio as $espacios)
                                    @if ($horarios->IdEspacio == $espacios->IdEspacio)
                                    <td id="IdEspacio">{{ $espacios->Nombre }}</td>
                                    @endif
                                    @endforeach
                                    <td id="HoraInicio">{{ $horarios->HoraInicio }}</td>
                                    <td id="HoraFinalizacion">{{ $horarios->HoraFinalizacion }}</td>
                                    <td id="FechaInicio">{{ $horarios->FechaInicio }}</td>
                                    <td id="FechaFin">{{ $horarios->FechaFin }}</td>
                                    <td id="Dia">{{ $horarios->Dia }}</td>
                                    <td id="Estado">{{ $horarios->Estado }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $horarios->IdHorario }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $horarios->IdHorario }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"
                                            onclick="modalDetalle({{ $horarios->IdHorario }})"><i
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

        <!-- Modal-->
        <div class="modal fade" id="ModalHorario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModal"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formHorario" name="formHorario">
                            <div class="form-group">
                                <label for="">usuario</label>
                                <select class="form-control" name="pIdUsuario" id="pIdUsuario">
                                    <option value="0">Seleccionar usuario</option>
                                    <option value="1">Carlos</option>
                                </select>
                                <label for="">Actividad</label>
                                <select class="form-control" name="pIdActividad" id="pIdActividad">
                                    <option value="1">Seleccionar actividad</option>
                                    @foreach ($actividad as $actividades)
                                        <option value="{{ $actividades->IdActividad }}">{{ $actividades->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Espacio</label>
                                <select class="form-control" name="pIdEspacio" id="pIdEspacio">
                                    <option value="1">Seleccionar espacio</option>
                                    @foreach ($espacio as $espacios)
                                        <option value="{{ $espacios->IdEspacio }}">{{ $espacios->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Hora Inicio</label>
                                <input class="form-control" type="time" name="pHoraInicio" id="pHoraInicio">
                                <label for="">Hora final</label>
                                <input class="form-control" type="time" name="pHoraFinalizacion" id="pHoraFinalizacion">
                                <label for="">Fecha Inicio</label>
                                <input type="date" class="form-control" name="pFechaInicio" id="pFechaInicio">
                                <label for="">Fecha Final</label>
                                <input type="date" class="form-control" name="pFechaFin" id="pFechaFin">
                                <label for="">Fecha Activación</label>
                                <input type="date" class="form-control" name="pFechaActivacion" id="pFechaActivacion">
                                <label for="">Dia</label>
                                <select class="form-control" name="pDia" id="pDia">
                                    <option value="0">Seleccionar dia</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miercoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sabado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                                <label for="">Estado</label>
                                <div style="display: flex; justify-content: space-around;">
                                    <div>
                                     <span>habilitado </span><input type="radio" class="form-control" id="pEstado" name="pEstado" value="1" checked>
                                    </div>
                                    <div>
                                        <span>Desabilitado</span><input type="radio" class="form-control" id="pEstado" name="pEstado" value="0">
                                    </div>

                                </div>
                                <input type="hidden" name="pIdHorario" id="pIdHorario" value="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" id="btnGuardar" type="button">Guardar</button>
                        <button class="btn btn-success" id="btnActualizar" type="button">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal-->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
        integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>

    <script>
        var table = $('#dataTable');

        // success alert
        function swal_success() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Accion realizada con exito!',
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Ocurrio un error!',
                showConfirmButton: true,
            })
        }
        //Modal de guardar
        $('#crearHorario').click(function() {
            $('#tituloModal').text("Registrar Horario");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');
            $("#pNombre").prop("disabled", false);
        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formHorario').serialize(),
                url: "{{ route('horarios.guardar') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formHorario').trigger("reset");
                    $('#ModalHorario').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(data) {
                    swal_error();
                    $('#btnGuardar').html('Error');
                }
            });
        });
        //Funcion del Modal Detalles
        function modalDetalle(IdHorario) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdHorario;
            let nombre = $("#" + row_id + " " + "#Nombre").text();

            $('#tituloModal').text("Detalles del Horario");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');

            $("#pNombre").prop("disabled", true);
            $('#pIdHorario').val(IdHorario);
            $('#pNombre').val(nombre);

        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdHorario) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdHorario;
            let nombre = $("#" + row_id + " " + "#Nombre").text();


            $('#tituloModal').text("Actualizar Departamento");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');
            $("#pNombre").prop("disabled", false);
            $('#pIdHorario').val(IdHorario);
            $('#pNombre').val(nombre);
        }
        //Mandar a actualizar los datos
        $('#btnActualizar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formHorario').serialize(),
                url: "{{ route('horarios.update') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formHorario').trigger("reset");
                    $('#ModalHorario').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(data) {
                    swal_error();
                    $('#btnActualizar').html('Error');
                }
            });
        });




        //Funcion para eliminar
        function eliminar(id) {
            Swal.fire({
                title: 'Esta seguro?',
                text: "Este acción no es reversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            IdDepartamento: id
                        },
                        url: "{{ route('horarios.delete') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire(
                                'Eliminado!',
                                'Se completo la acción',
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 2000)
                        },
                        error: function(data) {
                            swal_error();
                        }
                    });
                }
            })
        }
    </script>
@stop
