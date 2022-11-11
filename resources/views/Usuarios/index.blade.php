@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Usuarios</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearUsuario"><i
                                class="fas fa-plus"></i>Agregar Usuario</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Usuario</th>
                                <th>Tipo Usuario</th>
                                <th>Nombre</th>
                                <th>Primer Apellido</th>
                                <th>Segundo Apellido</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Fecha de nacimiento</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr id="row-{{ $usuario->IdUsuario }}">
                                    <td id="id">{{ $usuario->IdUsuario }}</td>
                                    <td id="TipoUsuario">{{ $usuario->TipoUsuario }}</td>
                                    <td id="Nombre">{{ $usuario->Nombre }}</td>
                                    <td id="Ape1">{{ $usuario->Ape1 }}</td>
                                    <td id="Ape2">{{ $usuario->Ape2 }}</td>
                                    <td id="EmailInst">{{ $usuario->EmailInst }}</td>
                                    <td id="Telefono">{{ $usuario->Telefono }}</td>
                                    <td id="Fecha_Nac">{{ $usuario->Fecha_Nac }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $usuario->IdUsuario }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $usuario->IdUsuario }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $usuario->IdUsuario }})"><i
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
        <div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formUsuario" name="formUsuario">
                            <div class="form-group">
                                <label for="">Tipo Usuario</label>
                                <select class="form-control" name="pTipoUsuario" id="pTipoUsuario">
                                    <option value="0">Seleccionar tipo de usuario</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Estudiante">Estudiante</option>
                                    <option value="Docente">Docente</option>
                                </select>
                                <label for="">DNI</label>
                                <input type="text" name="pDNI" class="form-control" id="pDNI"
                                placeholder="Escriba el DNI">
                                <label for="">Nombre</label>
                                <input type="text" name="pNombre" class="form-control" id="pNombre"
                                placeholder="Escriba el nombre">
                                <label for="">Primer Apellido</label>
                                <input type="text" name="pApe1" class="form-control" id="pApe1"
                                placeholder="Escriba el primer apellido">
                                <label for="">Segundo Apellido</label>
                                <input type="text" name="pApe2" class="form-control" id="pApe2"
                                placeholder="Escriba el segundo apellido">
                                <label for="">correo</label>
                                <input type="text" name="pEmailInst" class="form-control" id="pEmailInst"
                                placeholder="Escriba el correo">
                                <label for="">Teléfono</label>
                                <input type="number" name="pTelefono" class="form-control" id="pTelefono"
                                placeholder="Escriba el teléfono">
                                <label for="">Fecha Nacimiento</label>
                                <input type="date" class="form-control" name="pfecha_Nac" id="pfecha_Nac">
                                <input type="hidden" name="pIdUsuario" id="pIdUsuario" value="">
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
        $('#crearUsuario').click(function() {
            $('#tituloModal').text("Registrar Usuario");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formUsuario').trigger("reset");
            $('#ModalUsuario').modal('show');
            $( "#pIdUsuario" ).prop( "disabled", false );
            $( "#pTipoUsuario" ).prop( "disabled", false );
            $( "#pDNI" ).prop( "disabled", false );
            $( "#pNombre" ).prop( "disabled", false );
            $( "#pApe1" ).prop( "disabled", false );
            $( "#pApe2" ).prop( "disabled", false );
            $( "#pEmailInst" ).prop( "disabled", false );
            $( "#pTelefono" ).prop( "disabled", false );
            $( "#pfecha_Nac" ).prop( "disabled", false );

        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formUsuario').serialize(),
                url: "{{ route('usuarios.guardar') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formUsuario').trigger("reset");
                    $('#ModalUsuario').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(data) {
                    swal_error();
                //    $('#btnGuardar').html('Error');
                }
            });
        });
        //Funcion del Modal Detalles
        function modalDetalle(IdUsuario) {
            //Capturamos los valores de la tabla
            row_id = "row-"+IdUsuario;
         //   let dni = $("#"+ row_id + " " + "#DNI").text();
            let TipoUsuario = $("#"+ row_id + " " + "#TipoUsuario").text();
            let dni = $("#"+ row_id + " " + "#DNI").text();
            let nombre = $("#"+ row_id + " " + "#Nombre").text();
            let Ape1 = $("#"+ row_id + " " + "#Ape1").text();
            let Ape2 = $("#"+ row_id + " " + "#Ape2").text();
            let EmailInst = $("#"+ row_id + " " + "#EmailInst").text();
            let Telefono = $("#"+ row_id + " " + "#Telefono").text();
            let Fecha_Nac = $("#"+ row_id + " " + "#Fecha_Nac").text();

            $('#tituloModal').text("Detalles del usuario");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            $('#formUsuario').trigger("reset");
            $('#ModalUsuario').modal('show');

            $( "#pIdUsuario" ).prop( "disabled", true );
            $( "#pTipoUsuario" ).prop( "disabled", true );
            $( "#pDNI" ).prop( "disabled", true );
            $( "#pNombre" ).prop( "disabled", true );
            $( "#pApe1" ).prop( "disabled", true );
            $( "#pApe2" ).prop( "disabled", true );
            $( "#pEmailInst" ).prop( "disabled", true );
            $( "#pTelefono" ).prop( "disabled", true );
            $( "#pfecha_Nac" ).prop( "disabled", true );

            $('#pIdUsuario').val(IdUsuario);
        //    $('#pDNI').val(dni);
            $('#pNombre').val(nombre);
            $('#pTipoUsuario').val(TipoUsuario);
            $('#pApe1').val(Ape1);
            $('#pApe2').val(Ape2);
            $('#pEmailInst').val(EmailInst);
            $('#pTelefono').val(Telefono);
            $('#pfecha_Nac').val(Fecha_Nac);
        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdUsuario) {
            //Capturamos los valores de la tabla
            row_id = "row-"+IdUsuario;
            let TipoUsuario = $("#"+ row_id + " " + "#TipoUsuario").text();
            let dni = $("#"+ row_id + " " + "#DNI").text();
            let nombre = $("#"+ row_id + " " + "#Nombre").text();
            let Ape1 = $("#"+ row_id + " " + "#Ape1").text();
            let Ape2 = $("#"+ row_id + " " + "#Ape2").text();
            let EmailInst = $("#"+ row_id + " " + "#EmailInst").text();
            let Telefono = $("#"+ row_id + " " + "#Telefono").text();
            let Fecha_Nac = $("#"+ row_id + " " + "#Fecha_Nac").text();

            $('#tituloModal').text("Actualizar Usuario");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formUsuario').trigger("reset");
            $('#ModalUsuario').modal('show');
            $( "#pIdUsuario" ).prop( "disabled", false );
            $( "#pTipoUsuario" ).prop( "disabled", false );
            $( "#pDNI" ).prop( "disabled", false );
            $( "#pNombre" ).prop( "disabled", false );
            $( "#pApe1" ).prop( "disabled", false );
            $( "#pApe2" ).prop( "disabled", false );
            $( "#pEmailInst" ).prop( "disabled", false );
            $( "#pTelefono" ).prop( "disabled", false );
            $( "#pfecha_Nac" ).prop( "disabled", false );

            $('#pIdUsuario').val(IdUsuario);
        //    $('#pDNI').val(dni);
            $('#pNombre').val(nombre);
            $('#pTipoUsuario').val(TipoUsuario);
            $('#pApe1').val(Ape1);
            $('#pApe2').val(Ape2);
            $('#pEmailInst').val(EmailInst);
            $('#pTelefono').val(Telefono);
            $('#pfecha_Nac').val(Fecha_Nac);
        }
        //Mandar a actualizar los datos
        $('#btnActualizar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formUsuario').serialize(),
                url: "{{ route('usuarios.update') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formUsuario').trigger("reset");
                    $('#ModalUsuario').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(data) {
                    swal_error();
                 //   $('#btnActualizar').html('Error');
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
                            pIdUsuario: id
                        },
                        url: "{{ route('usuarios.delete') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire(
                                'Eliminado!',
                                'Se completo la acción',
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
