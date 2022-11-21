@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de tipo de espacios</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearTipoEspacio"><i
                                class="fas fa-plus"></i>Agregar Tipo de Espacio</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Tipo Espacio</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipoespacios as $tipoespacio)
                                <tr id="row-{{ $tipoespacio->IdTipoEspacio }}">
                                    <td id="id">{{ $tipoespacio->IdTipoEspacio }}</td>
                                    <td id="Nombre">{{ $tipoespacio->Nombre }}</td>
                                    <td id="Descripcion">{{ $tipoespacio->Descripcion }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $tipoespacio->IdTipoEspacio }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $tipoespacio->IdTipoEspacio }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"
                                            onclick="modalDetalle({{ $tipoespacio->IdTipoEspacio }})"><i
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
        <div class="modal fade" id="ModalTipoEspacio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formTipoEspacio" name="formTipoEspacio">
                            <div class="form-group">
                                <label for="">Nombre del tipo de espacio</label>
                                <input type="text" name="pNombre" class="form-control" id="pNombre"
                                    placeholder="Escriba el nombre" onkeyup="validation()" minlength="1" maxlength="50" required>
                                <span style="color: red" id="pNombreValidation">Campo requerido</span></br>
                                <label for="">Descripción</label>
                                <input type="text" name="pDescripcion" class="form-control" id="pDescripcion"
                                    placeholder="Escriba la descripción" onkeyup="validation()" minlength="0" maxlength="200">
                                <span style="color: red" id="pDescripcionValidation">Campo requerido</span></br>
                                <input type="hidden" name="pIdTipoEspacio" id="pIdTipoEspacio" value="">
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
                title: 'Ha ocurrido un error',
                showConfirmButton: true,
            })
        }
        //Modal de guardar
        $('#crearTipoEspacio').click(function() {
            $('#tituloModal').text("Registrar Tipo Espacio");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formTipoEspacio').trigger("reset");
            $('#ModalTipoEspacio').modal('show');
            $("#pNombre").prop("disabled", false);
            $("#pDescripcion").prop("disabled", false);
            limpiarValidaciones();
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
                    data: $('#formTipoEspacio').serialize(),
                    url: "{{ route('tipoespacios.guardar') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formTipoEspacio').trigger("reset");
                        $('#ModalTipoEspacio').modal('hide');
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
                validation();
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
            nombre = document.formTipoEspacio.pNombre;
            descripcion = document.formTipoEspacio.pDescripcion;

            if (nombre.value != "") {
                if (nombre.value.length < 50) {
                    var AllowRegex = new RegExp(/^[A-Za-zZñÑáéíóúÁÉÍÓÚ\s]+$/g);

                    if (!AllowRegex.test(nombre.value)) {
                        document.getElementById('pNombreValidation').innerHTML =
                            'No se permiten números ni caracteres especiales';
                        document.getElementById('pNombreValidation').style.color = 'red';
                        nombre.style.border = "1px solid red";
                        $('#pNombreValidation').show();
                        return false;
                    } else {
                        nombre.style.border = "1px solid #d1d3e2";
                        $('#pNombreValidation').hide();
                    }
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
            nombre = document.formTipoEspacio.pNombre;
            descripcion = document.formTipoEspacio.pDescripcion;

            nombre.style.border = "1px solid #d1d3e2";
            descripcion.style.border = "1px solid #d1d3e2";

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

            $('#tituloModal').text("Detalles del tipo de espacio");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            $('#formTipoEspacio').trigger("reset");
            $('#ModalTipoEspacio').modal('show');

            $("#pNombre").prop("disabled", true);
            $("#pDescripcion").prop("disabled", true);
            $("#pTipoActividad").prop("disabled", true);

            $('#pIdActividad').val(IdActividad);
            $('#pTipoActividad').val(tipoActividad);
            $('#pNombre').val(nombre);
            $('#pDescripcion').val(descripcion);
            limpiarValidaciones();
        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdTipoEspacio) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdTipoEspacio;
            let nombre = $("#" + row_id + " " + "#Nombre").text();
            let descripcion = $("#" + row_id + " " + "#Descripcion").text();

            $('#tituloModal').text("Actualizar tipo de espacio");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formTipoEspacio').trigger("reset");
            $('#ModalTipoEspacio').modal('show');
            $("#pNombre").prop("disabled", false);
            $("#pDescripcion").prop("disabled", false);
            $('#pIdTipoEspacio').val(IdTipoEspacio);
            $('#pNombre').val(nombre);
            $('#pDescripcion').val(descripcion);
            limpiarValidaciones();
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
                    data: $('#formTipoEspacio').serialize(),
                    url: "{{ route('tipoespacios.update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#formTipoEspacio').trigger("reset");
                        $('#ModalTipoEspacio').modal('hide');
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
                title: '¿Está seguro?',
                text: "Esta acción no es reversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            pIdTipoEspacio: id
                        },
                        url: "{{ route('tipoespacios.delete') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire(
                                'Eliminado',
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
