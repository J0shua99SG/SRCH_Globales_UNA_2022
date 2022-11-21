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
                                <tr id="row-{{ $horarios->IdHorario }}">
                                    <td id="id">{{ $horarios->IdHorario }}</td>
                                    <td id="nombre">{{ $horarios->Nombre }}</td>
                                    @foreach ($actividad as $actividades)
                                        @if ($horarios->IdActividad == $actividades->IdActividad)
                                            <td>{{ $actividades->Nombre }}
                                                <input type="hidden" id="IdActividad" value="{{ $horarios->IdActividad }}">
                                            </td>
                                        @endif
                                    @endforeach

                                    @foreach ($espacio as $espacios)
                                        @if ($horarios->IdEspacio == $espacios->IdEspacio)
                                            <td>{{ $espacios->Nombre }}
                                                <input type="hidden" id="IdEspacio" value="{{ $horarios->IdEspacio }}">
                                            </td>
                                        @endif
                                    @endforeach
                                    <td id="HoraInicio">{{ $horarios->HoraInicio }}</td>
                                    <td id="HoraFinalizacion">{{ $horarios->HoraFinalizacion }}</td>
                                    <td id="FechaInicio">{{ $horarios->FechaInicio }}</td>
                                    <td id="FechaFin">{{ $horarios->FechaFin }}</td>
                                    <td id="Dia">{{ $horarios->Dia }}</td>
                                    @if ($horarios->Estado == 1)
                                        <td id="Estado" value="{{ $horarios->Estado }}">Habilitado</td>
                                    @endif
                                    @if ($horarios->Estado == 0)
                                        <td id="Estado" value="{{ $horarios->Estado }}">Desabilitado</td>
                                    @endif
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
                                <label for="">Usuario</label>
                                <select class="form-control" name="pIdUsuario" id="pIdUsuario">
                                    <option value="">Seleccionar usuario</option>
                                    @foreach ($usuario as $usuarios)
                                        <option value="{{ $usuarios->IdUsuario }}">{{ $usuarios->Nombre }}
                                            {{ $usuarios->Ape1 }}</option>
                                    @endforeach
                                </select>
                                <label for="">Actividad</label>
                                <select class="form-control" name="pIdActividad" id="pIdActividad">
                                    <option value="">Seleccionar actividad</option>
                                    @foreach ($actividad as $actividades)
                                        <option value="{{ $actividades->IdActividad }}">{{ $actividades->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="">Espacio</label>
                                <select class="form-control" name="pIdEspacio" id="pIdEspacio">
                                    <option value="">Seleccionar espacio</option>
                                    @foreach ($espacio as $espacios)
                                        <option value="{{ $espacios->IdEspacio }}">{{ $espacios->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Hora Inicio</label>
                                <input class="form-control" type="time" name="pHoraInicio" id="pHoraInicio">
                                <span id="horaInicio" style="color: red; display:none">Campo requerido</span><br>
                                <label for="">Hora final</label>
                                <input class="form-control" type="time" name="pHoraFinalizacion" id="pHoraFinalizacion">
                                <span id="horaFIn" style="color: red; display:none">Campo requerido</span><br>
                                <label for="">Fecha Inicio</label>
                                <input type="date" class="form-control" name="pFechaInicio" id="pFechaInicio"
                                    min="{{ date('Y-m-d') }}">
                                <span id="fechaIni" style="color: red; display:none">Campo requerido</span><br>
                                <label for="">Fecha Final</label>
                                <input type="date" class="form-control" name="pFechaFin" id="pFechaFin"
                                    min="{{ date('Y-m-d') }}">
                                <span id="fechaFin" style="color: red; display:none">Campo requerido</span><br>
                                <label for="">Fecha Activación</label>
                                <input type="date" class="form-control" name="pFechaActivacion" id="pFechaActivacion"
                                    min="{{ date('Y-m-d') }}">
                                <span id="fechaActiv" style="color: red; display:none">Campo requerido</span><br>
                                <label for="">Dia</label>
                                <select class="form-control" name="pDia" id="pDia">
                                    <option value="">Seleccionar dia</option>
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
                                        <span>habilitado </span><input type="radio" class="form-control" id="pEstado1"
                                            name="pEstado" value="1" checked>
                                    </div>
                                    <div>
                                        <span>Desabilitado</span><input type="radio" class="form-control"
                                            id="pEstado0" name="pEstado" value="0">
                                    </div>

                                </div>
                                <span id="estadoHorario" style="color: red; display:none">Campo requerido</span><br>
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
        function swal_success(response) {
            Swal.fire({
                position: 'centered',
                icon: 'success',
                title: response,
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
            limpiarValidaciones();
            $('#tituloModal').text("Registrar Horario");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');
            $("#pIdUsuario").prop("disabled", false);
            $("#pIdActividad").prop("disabled", false);
            $("#pIdEspacio").prop("disabled", false);
            $("#pHoraInicio").prop("disabled", false);
            $("#pHoraFinalizacion").prop("disabled", false);
            $("#pFechaInicio").prop("disabled", false);
            $("#pFechaFin").prop("disabled", false);
            $("#pFechaActivacion").prop("disabled", false);
            $("#pDia").prop("disabled", false);
            $("#pEstado").prop("disabled", false);
        });
        function limpiarValidaciones(){
            let usuario = $("#pIdUsuario").css({"border": "1px solid #d1d3e2" });
            let actividad = $("#pIdActividad").css({"border": "1px solid #d1d3e2" });
            let espacio = $("#pIdEspacio").css({"border": "1px solid #d1d3e2" });
            let horaInicio = $("#pHoraInicio").css({"border": "1px solid #d1d3e2" });
            let horaFin = $("#pHoraFinalizacion").css({"border": "1px solid #d1d3e2" });
            let fechaInicio = $("#pFechaInicio").css({"border": "1px solid #d1d3e2" });
            let fechaFin = $("#pFechaFin").css({"border": "1px solid #d1d3e2" });
            let fechaActivacion = $("#pFechaActivacion").css({"border": "1px solid #d1d3e2" });
            $("#horaInicio").hide();
            $("#fechaIni").hide();
        }

        function validaciones() {

            let usuario = $("#pIdUsuario").val();
            let actividad = $("#pIdActividad").val();
            let espacio = $("#pIdEspacio").val();
            let horaInicio = $("#pHoraInicio").val();
            let horaFin = $("#pHoraFinalizacion").val();
            let fechaInicio = $("#pFechaInicio").val();
            let fechaFin = $("#pFechaFin").val();
            let fechaActivacion = $("#pFechaActivacion").val();
            let dia = $("#pDia").val();
            var hoy = new Date();
            var FechaAhora = hoy.toLocaleDateString('es-CR');

            if (horaInicio == "") {
                $("#pHoraInicio").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pHoraInicio").css({
                    "border": "1px solid green"
                });
            }
            if (horaFin == "") {
                $("#pHoraFinalizacion").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pHoraFinalizacion").css({
                    "border": "1px solid green"
                });
            }
            if (fechaInicio == "") {
                $("#pFechaInicio").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pFechaInicio").css({
                    "border": "1px solid green"
                });
            }
            if (fechaFin == "") {
                $("#pFechaFin").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pFechaFin").css({
                    "border": "1px solid green"
                });
            }
            if (fechaActivacion == "") {
                $("#pFechaActivacion").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pFechaActivacion").css({
                    "border": "1px solid green"
                });
            }
            if (dia == "") {
                $("#pDia").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pDia").css({
                    "border": "1px solid green"
                });
            }

            if (usuario == "") {
                $("#pIdUsuario").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pIdUsuario").css({
                    "border": "1px solid green"
                });
            }
            if (actividad == "") {
                $("#pIdActividad").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pIdActividad").css({
                    "border": "1px solid green"
                });
            }
            if (espacio == "") {
                $("#pIdEspacio").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pIdEspacio").css({
                    "border": "1px solid green"
                });
            }
            if (horaInicio > horaFin) {
                $("#pHoraInicio").css({
                    "border": "1px solid red"
                });
                $("#horaInicio").text("La hora de inicio tiene que ser menor a la hora final");
                $("#horaInicio").show();
                return false;
            } else {
                $("#horaInicio").text("Campo requerido");
                $("#horaInicio").hide();
            }
            if(FechaAhora < fechaInicio){
                $("#pFechaInicio").css({
                    "border": "1px solid red"
                });
                $("#fechaIni").text("La fecha de inicio tiene que ser mayor a la fecha de hoy");
                $("#fechaIni").show();
                return false;
            }
            if (fechaInicio > fechaFin) {
                $("#pFechaInicio").css({
                    "border": "1px solid red"
                });
                $("#fechaIni").text("La fecha de inicio tiene que ser menor a la fecha final");
                $("#fechaIni").show();
                return false;
            } else {
                $("#fechaIni").text("Campo requerido");
                $("#fechaIni").hide();
            }
            return true;
        }
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            val = validaciones();
            if (val == true) {
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
                        swal_success(data.success);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(data) {
                        swal_error();
                    }
                });
            } else {
                Swal.fire({
                    position: 'centered',
                    icon: 'error',
                    title: 'Complete los campos!',
                    showConfirmButton: true,
                })
            }

        });
        //Funcion del Modal Detalles
        function modalDetalle(IdHorario) {
            limpiarValidaciones();
            //Capturamos los valores de la tabla
            row_id = "row-" + IdHorario;
            let usuario = $("#" + row_id + " " + "#nombre").text();
            let actividad = $("#" + row_id + " " + "#IdActividad").val();
            let espacio = $("#" + row_id + " " + "#IdEspacio").val();
            let horaInicio = $("#" + row_id + " " + "#HoraInicio").text();
            let horaFinalizacion = $("#" + row_id + " " + "#HoraFinalizacion").text();
            let fechaInicio = $("#" + row_id + " " + "#FechaInicio").text();
            let fechaFin = $("#" + row_id + " " + "#FechaFin").text();
            //            let fechaActivacion = $("#" + row_id + " " + "#pFechaActivacion").text();
            let dia = $("#" + row_id + " " + "#Dia").text();
            let estado = $("#" + row_id + " " + "#Estado").text();
            $('#tituloModal').text("Detalles del Horario");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');

            $("#pIdUsuario").prop("disabled", true);
            $("#pIdActividad").prop("disabled", true);
            $("#pIdEspacio").prop("disabled", true);
            $("#pHoraInicio").prop("disabled", true);
            $("#pHoraFinalizacion").prop("disabled", true);
            $("#pFechaInicio").prop("disabled", true);
            $("#pFechaFin").prop("disabled", true);
            $("#pFechaActivacion").prop("disabled", true);
            $("#pDia").prop("disabled", true);
            $("#pEstado1").prop("disabled", true);
            $("#pEstado0").prop("disabled", true);
            $('#pIdUsuario').val(usuario);
            $("#pIdActividad").val(actividad);
            $('#pIdEspacio').val(espacio);
            $('#pHoraInicio').val(horaInicio);
            $('#pHoraFinalizacion').val(horaFinalizacion);
            $('#pFechaInicio').val(fechaInicio);
            $('#pFechaFin').val(fechaFin);
            //           $('#pFechaActivacion').val(fechaActivacion);
            $('#pDia').val(dia);
            if (estado == "Habilitado") {
                $("#pEstado1").prop("checked", true);
            }
            if (estado == "Desabilitado") {
                $("#pEstado0").prop("checked", true);
            }

        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdHorario) {
            limpiarValidaciones();
            //Capturamos los valores de la tabla
            row_id = "row-" + IdHorario;
            let usuario = $("#" + row_id + " " + "#nombre").text();
            let actividad = $("#" + row_id + " " + "#IdActividad").val();
            let espacio = $("#" + row_id + " " + "#IdEspacio").val();
            let horaInicio = $("#" + row_id + " " + "#HoraInicio").text();
            let horaFinalizacion = $("#" + row_id + " " + "#HoraFinalizacion").text();
            let fechaInicio = $("#" + row_id + " " + "#FechaInicio").text();
            let fechaFin = $("#" + row_id + " " + "#FechaFin").text();
            //            let fechaActivacion = $("#" + row_id + " " + "#pFechaActivacion").text();
            let dia = $("#" + row_id + " " + "#Dia").text();
            let estado = $("#" + row_id + " " + "#Estado").text();
            $('#tituloModal').text("Actualizar Horario");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formHorario').trigger("reset");
            $('#ModalHorario').modal('show');

            $("#pIdUsuario").prop("disabled", false);
            $("#pIdActividad").prop("disabled", false);
            $("#pIdEspacio").prop("disabled", false);
            $("#pHoraInicio").prop("disabled", false);
            $("#pHoraFinalizacion").prop("disabled", false);
            $("#pFechaInicio").prop("disabled", false);
            $("#pFechaFin").prop("disabled", false);
            $("#pFechaActivacion").prop("disabled", false);
            $("#pDia").prop("disabled", false);
            $("#pEstado1").prop("disabled", false);
            $("#pEstado0").prop("disabled", false);
            $('#pIdUsuario').val(1);
            $("#pIdActividad").val(actividad);
            $('#pIdEspacio').val(espacio);
            $('#pHoraInicio').val(horaInicio);
            $('#pHoraFinalizacion').val(horaFinalizacion);
            $('#pFechaInicio').val(fechaInicio);
            $('#pFechaFin').val(fechaFin);
            //           $('#pFechaActivacion').val(fechaActivacion);
            $('#pDia').val(dia);
            if (estado == "Habilitado") {
                $("#pEstado1").prop("checked", true);
            }
            if (estado == "Desabilitado") {
                $("#pEstado0").prop("checked", true);
            }
            $('#pIdHorario').val(IdHorario);

        }
        //Mandar a actualizar los datos
        $('#btnActualizar').click(function(e) {
            e.preventDefault();
            val = validaciones();
            if (val == true) {
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
                        swal_success(data.success);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(data) {
                        swal_error();
                    }
                });
            } else {
                Swal.fire({
                    position: 'centered',
                    icon: 'error',
                    title: 'Complete los campos!',
                    showConfirmButton: true,
                })
            }

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
                                data.success,
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
