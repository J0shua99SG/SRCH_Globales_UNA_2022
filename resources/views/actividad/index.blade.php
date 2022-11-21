@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Actividades</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearActividad"><i
                                class="fas fa-plus"></i>Agregar Actividad</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Actividad</th>
                                <th>Tipo Actividad</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
                                <tr id="row-{{ $actividad->IdActividad }}">
                                    <td id="id">{{ $actividad->IdActividad }}</td>
                                    <td id="TipoActividad">{{ $actividad->TipoActividad }}</td>
                                    <td id="Nombre">{{ $actividad->Nombre }}</td>
                                    <td id="Descripcion">{{ $actividad->Descripcion }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $actividad->IdActividad }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $actividad->IdActividad }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"
                                            onclick="modalDetalle({{ $actividad->IdActividad }})"><i
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
        <div class="modal fade" id="ModalActividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formActividad" name="formActividad">
                            <div class="form-group">
                                <label for="">Tipo de actividad</label>
                                <input type="text" name="pTipoActividad" class="form-control" id="pTipoActividad"
                                    placeholder="Escriba el tipo de actividad" onkeyup="validation()" maxlength="50">
                                <span style="color: red" id="pTipoValidation">Campo requerido</span></br>
                                <label for="">Nombre de la actividad</label>
                                <input type="text" name="pNombre" class="form-control" id="pNombre"
                                    placeholder="Escriba el nombre" onkeyup="validation()" maxlength="50">
                                <span style="color: red" id="pNombreValidation">Campo requerido</span></br>
                                <label for="">Descripción</label>
                                <textarea type="text" name="pDescripcion" class="form-control" id="pDescripcion" placeholder="Escriba la descripción"
                                    onkeyup="validation()" maxlength="100"></textarea>
                                <span style="color: red" id="pDescripcionValidation">Campo requerido</span></br>
                                <input type="hidden" name="pIdActividad" id="pIdActividad" value="">
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
        $('#crearActividad').click(function() {
            $('#tituloModal').text("Registrar Actividad");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            limpiarValidaciones();
            $('#formActividad').trigger("reset");
            $('#ModalActividad').modal('show');
            $("#pNombre").prop("disabled", false);
            $("#pDescripcion").prop("disabled", false);
            $("#pTipoActividad").prop("disabled", false);
        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            vali = validation();
            e.preventDefault();
            if (vali == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('#formActividad').serialize(),
                    url: "{{ route('actividad.guardar') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formActividad').trigger("reset");
                        $('#ModalActividad').modal('hide');
                        swal_success(data.success);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(data) {
                        validation();
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
            tipo = document.formActividad.pTipoActividad;
            nombre = document.formActividad.pNombre;
            descripcion = document.formActividad.pDescripcion;

            if (tipo.value != "") {
                if (tipo.value.length < 50) {
                    tipo.style.border = "1px solid #d1d3e2";
                    $('#pTipoValidation').hide();
                } else {
                    document.getElementById('pTipoValidation').innerHTML = 'Solo se admiten 50 caracteres';
                    document.getElementById('pTipoValidation').style.color = 'red';
                    $('#pTipoValidation').show();
                }
            } else {
                document.getElementById('pTipoValidation').innerHTML = 'Campo requerido';
                document.getElementById('pTipoValidation').style.color = 'red';
                tipo.style.border = "1px solid red";
                $('#pTipoValidation').show();
                return false;
            }
            if (nombre.value != "") {
                if (nombre.value.length < 50) {
                    nombre.style.border = "1px solid #d1d3e2";
                    $('#pNombreValidation').hide();
                } else {
                    document.getElementById('pNombreValidation').innerHTML = 'Solo se admiten 50 caracteres';
                    document.getElementById('pNombreValidation').style.color = 'red';
                    $('#pNombreValidation').show();
                }
            } else {
                document.getElementById('pNombreValidation').innerHTML = 'Campo requerido';
                document.getElementById('pNombreValidation').style.color = 'red';
                nombre.style.border = "1px solid red";
                $('#pNombreValidation').show();
                return false;
            }
            if (descripcion.value.length < 100) {
                descripcion.style.border = "1px solid #d1d3e2";
                $('#pDescripcionValidation').hide();
            } else {
                document.getElementById('pDescripcionValidation').innerHTML = 'Solo se admiten 100 caracteres';
                document.getElementById('pDescripcionValidation').style.color = 'red';
                $('#pDescripcionValidation').show();
            }
            return true;
        }

        function limpiarValidaciones() {
            tipo = document.formActividad.pTipoActividad;
            nombre = document.formActividad.pNombre;
            descripcion = document.formActividad.pDescripcion;

            tipo.style.border = "1px solid #d1d3e2";
            nombre.style.border = "1px solid #d1d3e2";
            descripcion.style.border = "1px solid #d1d3e2";

            $('#pTipoValidation').hide();
            $('#pNombreValidation').hide();
            $('#pDescripcionValidation').hide();
        }

        //Funcion del Modal Detalles
        function modalDetalle(IdActividad) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdActividad;
            let tipoActividad = $("#" + row_id + " " + "#TipoActividad").text();
            let nombre = $("#" + row_id + " " + "#Nombre").text();
            let descripcion = $("#" + row_id + " " + "#Descripcion").text();

            $('#tituloModal').text("Detalles de la actividad");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            limpiarValidaciones();
            $('#formActividad').trigger("reset");
            $('#ModalActividad').modal('show');

            $("#pNombre").prop("disabled", true);
            $("#pDescripcion").prop("disabled", true);
            $("#pTipoActividad").prop("disabled", true);

            $('#pIdActividad').val(IdActividad);
            $('#pTipoActividad').val(tipoActividad);
            $('#pNombre').val(nombre);
            $('#pDescripcion').val(descripcion);
        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdActividad) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdActividad;
            let tipoActividad = $("#" + row_id + " " + "#TipoActividad").text();
            let nombre = $("#" + row_id + " " + "#Nombre").text();
            let descripcion = $("#" + row_id + " " + "#Descripcion").text();

            $('#tituloModal').text("Actualizar Actividad");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formActividad').trigger("reset");
            $('#ModalActividad').modal('show');
            limpiarValidaciones();
            $("#pNombre").prop("disabled", false);
            $("#pDescripcion").prop("disabled", false);
            $("#pTipoActividad").prop("disabled", false);
            $('#pIdActividad').val(IdActividad);
            $('#pTipoActividad').val(tipoActividad);
            $('#pNombre').val(nombre);
            $('#pDescripcion').val(descripcion);
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
                    data: $('#formActividad').serialize(),
                    url: "{{ route('actividad.update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formActividad').trigger("reset");
                        $('#ModalActividad').modal('hide');
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
                validation();
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
                            IdActividad: id
                        },
                        url: "{{ route('actividad.delete') }}",
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
