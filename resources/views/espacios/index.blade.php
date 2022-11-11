@extends('layout.master')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Espacios</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearEspacio"><i
                                class="fas fa-plus"></i>Agregar Espacio</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Espacio</th>
                                <th>Edificio</th>
                                <th>Tipo Espacio</th>
                                <th>Departamento</th>
                                <th>Nombre</th>
                                <th>Planta</th>
                                <th>Capacidad Maxima</th>
                                <th>Estado</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($espacios as $espacio)
                                <tr id="row-{{ $espacio->IdEspacio }}">
                                    <td id="id">{{ $espacio->IdEspacio }}</td>
                                    @foreach ($edificios as $edificio)
                                    @if ($espacio->IdEdificio == $edificio->IdEdificio)
                                    <td >{{ $edificio->Nombre }}
                                    <input type="hidden" id="IdEdificio" value="{{$espacio->IdEdificio}}"></td>
                                    @endif
                                    @endforeach

                                    @foreach ($tipoespacios as $tipoespacio)
                                    @if ($espacio->IdTipoEspacio == $tipoespacio->IdTipoEspacio)
                                    <td>{{ $tipoespacio->Nombre }}
                                        <input type="hidden" id="IdTipoEspacio" value="{{$espacio->IdTipoEspacio}}"></td>
                                    @endif
                                    @endforeach
                                    @foreach ($departamento as $departamentos)
                                    @if ($espacio->IdDepartamento == $departamentos->IdDepartamento)
                                    <td>{{ $departamentos->Nombre }}
                                        <input type="hidden" id="IdDepartamento" value="{{$espacio->IdDepartamento}}"></td>
                                    @endif
                                    @endforeach
                                    <td id="nombre">{{ $espacio->Nombre }}</td>
                                    <td id="Planta">{{ $espacio->Planta }}</td>
                                    <td id="CapacidadMAx">{{ $espacio->CapacidadMAx }}</td>
                                    @if ($espacio->EstadoEspacio ==1)
                                    <td id="Estado"  value="{{$espacio->EstadoEspacio}}">Habilitado</td>
                                    @endif
                                    @if ($espacio->EstadoEspacio == 0)
                                    <td id="Estado" value="{{$espacio->EstadoEspacio}}">Desabilitado</td>
                                    @endif
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                            onclick="modalActualizar({{ $espacio->IdEspacio }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $espacio->IdEspacio }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"
                                            onclick="modalDetalle({{ $espacio->IdEspacio }})"><i
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
        <div class="modal fade" id="ModalEspacio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formEspacio" name="formEspacio">
                            <div class="form-group">
                                <label for="">Edificio</label>
                                <select class="form-control" name="pIdEdificio" id="pIdEdificio">
                                    <option value="1">Seleccionar edificio</option>
                                    @foreach ($edificios as $edificio)
                                        <option value="{{ $edificio->IdEdificio }}">{{ $edificio->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Tipo de Espacio</label>
                                <select class="form-control" name="pIdTipoEspacio" id="pIdTipoEspacio">
                                    <option value="1">Seleccionar tipo de espacio</option>
                                    @foreach ($tipoespacios as $tipoespacio)
                                        <option value="{{ $tipoespacio->IdTipoEspacio }}">{{ $tipoespacio->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Departamento</label>
                                <select class="form-control" name="pIdDepartamento" id="pIdDepartamento">
                                    <option value="1">Seleccionar departamento</option>
                                    @foreach ($departamento as $departamentos)
                                        <option value="{{ $departamentos->IdDepartamento }}">{{ $departamentos->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Nombre</label>
                                <input type="text" name="pNombre" class="form-control" id="pNombre"
                                placeholder="Escriba el nombre">
                                <label for="">Planta</label>
                                <input type="number" name="pPlanta" class="form-control" id="pPlanta"
                                placeholder="Escriba la planta">
                                <label for="">Capacidad Maxima</label>
                                <input type="number" name="pCapacidadMax" class="form-control" id="pCapacidadMax"
                                placeholder="Escriba la capacidad maxima">
                                <label for="">Estado</label>
                                <div style="display: flex; justify-content: space-around;">
                                    <div>
                                     <span>habilitado </span><input type="radio" class="form-control" id="pEstadoEspacio1" name="pEstadoEspacio" value="1">
                                    </div>
                                    <div>
                                        <span>Desabilitado</span><input type="radio" class="form-control" id="pEstadoEspacio0" name="pEstadoEspacio" value="0">
                                    </div>

                                </div>
                                <input type="hidden" name="pIdEspacio" id="pIdEspacio" value="">
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
        $('#crearEspacio').click(function() {
            $('#tituloModal').text("Registrar Espacio");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formEspacio').trigger("reset");
            $('#ModalEspacio').modal('show');
            $("#pIdEdificio").prop("disabled", false);
            $("#pIdTipoEspacio").prop("disabled", false);
            $("#pIdDepartamento").prop("disabled", false);
            $("#pNombre").prop("disabled", false);
            $("#pPlanta").prop("disabled", false);
            $("#pCapacidadMax").prop("disabled", false);
            $("#pEstadoEspacio1").prop("disabled", false);
            $("#pEstadoEspacio0").prop("disabled", false);
        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formEspacio').serialize(),
                url: "{{ route('espacios.guardar') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formEspacio').trigger("reset");
                    $('#ModalEspacio').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000); 
                },
                error: function(data) {
                    swal_error();
                }
            });
        });
        //Funcion del Modal Detalles
        function modalDetalle(IdEspacio) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdEspacio;
            let nombre = $("#" + row_id + " " + "#nombre").text();
            let IdTipoEspacio = $("#" + row_id + " " + "#IdTipoEspacio").val();
            let IdDepartamento = $("#" + row_id + " " + "#IdDepartamento").val();
            let IdEdificio = $("#" + row_id + " " + "#IdEdificio").val();
            let Planta = $("#" + row_id + " " + "#Planta").text();
            let CapacidadMAx = $("#" + row_id + " " + "#CapacidadMAx").text();
            let Estado = $("#" + row_id + " " + "#Estado").text();

            $('#tituloModal').text("Detalles del Espacio");
            $('#btnGuardar').hide();
            $('#btnActualizar').hide();
            $('#formEspacio').trigger("reset");
            $('#ModalEspacio').modal('show');

            $("#pIdEdificio").prop("disabled", true);
            $("#pIdTipoEspacio").prop("disabled", true);
            $("#pIdDepartamento").prop("disabled", true);
            $("#pNombre").prop("disabled", true);
            $("#pPlanta").prop("disabled", true);
            $("#pCapacidadMax").prop("disabled", true);
            $("#pIdEspacio").prop("disabled", true);
            $("#pEstadoEspacio1").prop("disabled", true);
            $("#pEstadoEspacio0").prop("disabled", true);

            $("#pNombre").val(nombre);
            $('#pIdTipoEspacio').val(IdTipoEspacio);
            $('#pIdDepartamento').val(IdDepartamento);
            $('#pIdEdificio').val(IdEdificio);
            $('#pPlanta').val(Planta);
            $('#pCapacidadMax').val(CapacidadMAx);

            if(Estado == "Habilitado"){
                $("#pEstadoEspacio1").prop("checked", true);
            }
            if(Estado == "Desabilitado"){
                $("#pEstadoEspacio0").prop("checked", true);
            }

        }
        //Funcion del Modal Actualizar
        function modalActualizar(IdEspacio) {
            //Capturamos los valores de la tabla
            row_id = "row-" + IdEspacio;
            let nombre = $("#" + row_id + " " + "#nombre").text();
            let IdTipoEspacio = $("#" + row_id + " " + "#IdTipoEspacio").val();
            let IdDepartamento = $("#" + row_id + " " + "#IdDepartamento").val();
            let IdEdificio = $("#" + row_id + " " + "#IdEdificio").val();
            let Planta = $("#" + row_id + " " + "#Planta").text();
            let CapacidadMAx = $("#" + row_id + " " + "#CapacidadMAx").text();
            let Estado = $("#" + row_id + " " + "#Estado").text();


            $('#tituloModal').text("Actualizar Espacio");
            $('#btnGuardar').hide();
            $('#btnActualizar').show();
            $('#formEspacio').trigger("reset");
            $('#ModalEspacio').modal('show');

            $("#pIdEdificio").prop("disabled", false);
            $("#pIdTipoEspacio").prop("disabled", false);
            $("#pIdDepartamento").prop("disabled", false);
            $("#pNombre").prop("disabled", false);
            $("#pPlanta").prop("disabled", false);
            $("#pCapacidadMax").prop("disabled", false);
            $("#pIdEspacio").prop("disabled", false);
            $("#pEstadoEspacio1").prop("disabled", false);
            $("#pEstadoEspacio0").prop("disabled", false);
            $("#pNombre").val(nombre);
            $("#pIdEspacio").val(IdEspacio);
            $('#pIdTipoEspacio').val(IdTipoEspacio);
            $('#pIdDepartamento').val(IdDepartamento);
            $('#pIdEdificio').val(IdEdificio);
            $('#pPlanta').val(Planta);
            $('#pCapacidadMax').val(CapacidadMAx);
            if(Estado == "Habilitado"){
                $("#pEstadoEspacio1").prop("checked", true);
            }
            if(Estado == "Desabilitado"){
                $("#pEstadoEspacio0").prop("checked", true);
            }
        }
        //Mandar a actualizar los datos
        $('#btnActualizar').click(function(e) {
            e.preventDefault();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formEspacio').serialize(),
                url: "{{ route('espacios.update') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formEspacio').trigger("reset");
                    $('#ModalEspacio').modal('hide');
                    swal_success();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(data) {
                    swal_error();
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
                            pIdEspacio: id
                        },
                        url: "{{ route('espacios.delete') }}",
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
