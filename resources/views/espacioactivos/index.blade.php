@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de espacios activos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearEspacioActivos"><i
                                class="fas fa-plus"></i>Agregar Espacio Activos</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Espacio Activo</th>
                                <th>Espacio</th>
                                <th>Activo</th>
                                <th>Cantidad</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($espacioactivos as $espacioactivo)
                                <tr id="row-{{ $espacioactivo->IdEspacio_activo }}">
                                    <td id="id">{{ $espacioactivo->IdEspacio_activo }}</td>
                                    @foreach ($espacios as $espacio)
                                        @if ($espacioactivo->IdEspacio == $espacio->IdEspacio)
                                            <td>{{ $espacio->Nombre }}
                                                <input type="hidden" id="IdEspacio"
                                                    value="{{ $espacioactivo->IdEspacio }}">
                                            </td>
                                        @endif
                                    @endforeach
                                    @foreach ($activos as $activo)
                                        @if ($espacioactivo->IdActivo == $activo->IdActivo)
                                            <td>{{ $activo->Nombre }}
                                                <input type="hidden" id="IdActivo" value="{{ $espacioactivo->IdActivo }}">
                                            </td>
                                        @endif
                                    @endforeach
                                    <td id="Cantidad">{{ $espacioactivo->Cantidad }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $espacioactivo->IdEspacio_activo }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $espacioactivo->IdEspacio_activo }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"
                                            onclick="modalDetalle({{ $espacioactivo->IdEspacio_activo }})"><i
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
        <div class="modal fade" id="ModalEspacioActivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formEspacioActivo" name="formEspacioActivo">
                            <div class="form-group">
                                <label for="">Espacio</label>
                                <select class="form-control" name="pIdEspacio" id="pIdEspacio" onchange="validation()">
                                    <option value="">Seleccionar espacio</option>
                                    @foreach ($espacios as $espacio)
                                        <option value="{{ $espacio->IdEspacio }}">{{ $espacio->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Activo</label>
                                <select class="form-control" name="pIdActivo" id="pIdActivo" onchange="validation()">
                                    <option value="">Seleccionar activo</option>
                                    @foreach ($activos as $activo)
                                        <option value="{{ $activo->IdActivo }}">{{ $activo->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Cantidad</label>
                                <input type="number" name="pCantidad" class="form-control" id="pCantidad"
                                    placeholder="Escriba la cantidad" onkeyup="validation()" min="0" max="9999"
                                    required>
                                <span style="color: red" id="pCantidadValidation">Campo requerido</span></br>
                                <input type="hidden" name="pIdEspacioActivo" id="pIdEspacioActivo" value="">
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
        $('#crearEspacioActivos').click(function() {
            $('#tituloModal').text("Registrar Espacio Activo");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            limpiarValidaciones();
            $('#formEspacioActivo').trigger("reset");
            $('#ModalEspacioActivo').modal('show');
            $("#pIdEspacio").prop("disabled", false);
            $("#pIdActivo").prop("disabled", false);
            $("#pCantidad").prop("disabled", false);
        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            vali = validation();
            if (vali == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('#formEspacioActivo').serialize(),
                    url: "{{ route('espacioactivos.guardar') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formEspacioActivo').trigger("reset");
                        $('#ModalEspacioActivo').modal('hide');
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
        //Validación: Cuando cambie el valor y mostrar mensages
        function validation() {
            cantidad = document.formEspacioActivo.pCantidad;
            let activo = $("#pIdActivo").val();
            let espacio = $("#pIdEspacio").val();

            if (activo == "") {
                $("#pIdActivo").css({
                    "border": "1px solid red"
                });
                return false;
            } else {
                $("#pIdActivo").css({
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

            if (cantidad.value != "") {
                if (cantidad.value.length < 4) {
                    cantidad.style.border = "1px solid #d1d3e2";
                    $('#pCantidadValidation').hide();
                } else {
                    document.getElementById('pCantidadValidation').innerHTML = 'Solo se admite una cantidad maxima de 9999';
                    document.getElementById('pCantidadValidation').style.color = 'red';
                    $('#pCantidadValidation').show();
                }
            } else {
                cantidad.style.border = "1px solid red";
                $('#pCantidadValidation').show();
                return false;
            }
            return true;
        }

        function limpiarValidaciones() {
            cantidad = document.formEspacioActivo.pCantidad;

            cantidad.style.border = "1px solid #d1d3e2";

            $('#pCantidadValidation').hide();
        }

        //Funcion del Modal Detalles
        function modalDetalle(IdEspacio_activo) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdEspacio_activo;
            let IdEspacio = $("#" + row_id + " " + "#IdEspacio").val();
            let IdActivo = $("#" + row_id + " " + "#IdActivo").val();
            let Cantidad = $("#" + row_id + " " + "#Cantidad").text();
            console.log("Espacio " + IdEspacio);
            console.log("Activo " + IdActivo);


            $('#tituloModal').text("Detalles de espacio activo");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            limpiarValidaciones();
            $('#formEspacioActivo').trigger("reset");
            $('#ModalEspacioActivo').modal('show');

            $("#pIdEspacio").prop("disabled", true);
            $("#pIdActivo").prop("disabled", true);
            $("#pCantidad").prop("disabled", true);

            $('#pIdEspacioActivo').val(IdEspacio_activo);
            $('#pIdEspacio').val(IdEspacio);
            $('#pIdActivo').val(IdActivo);
            $('#pCantidad').val(Cantidad);
        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdEspacio_activo) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdEspacio_activo;
            let IdEspacio = $("#" + row_id + " " + "#IdEspacio").val();
            let IdActivo = $("#" + row_id + " " + "#IdActivo").val();
            let Cantidad = $("#" + row_id + " " + "#Cantidad").text();

            $('#tituloModal').text("Actualizar espacio activo");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formEspacioActivo').trigger("reset");
            $('#ModalEspacioActivo').modal('show');
            limpiarValidaciones();
            $("#pIdEspacio").prop("disabled", false);
            $("#pIdActivo").prop("disabled", false);
            $("#pCantidad").prop("disabled", false);

            $('#pIdEspacioActivo').val(IdEspacio_activo);
            $('#pIdEspacio').val(IdEspacio);
            $('#pIdActivo').val(IdActivo);
            $('#pCantidad').val(Cantidad);
        }
        //Mandar a actualizar los datos
        $('#btnActualizar').click(function(e) {
            e.preventDefault();
            vali = validation();
            if (vali == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('#formEspacioActivo').serialize(),
                    url: "{{ route('espacioactivos.update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formEspacioActivo').trigger("reset");
                        $('#ModalEspacioActivo').modal('hide');
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
                            pIdEspacioActivo: id
                        },
                        url: "{{ route('espacioactivos.delete') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire(
                                'Eliminado!',
                                data.success,
                                'success'
                            )
                            setTimeout(function() { // wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
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
