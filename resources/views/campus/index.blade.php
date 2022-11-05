@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Campus</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                            class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearCampus"><i
                                class="fas fa-plus"></i>Agregar Campus</button></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Campus</th>
                                <th>Nombre</th>
                                <th>Sede</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campus as $campu)
                                <tr>
                                    <td>{{ $campu->IdCampus }}</td>
                                    <td>{{ $campu->Nombre }}</td>
                                    <td>{{ $campu->Sede }}</td>
                                    <td>{{ $campu->direccion }}</td>
                                    <td>{{ $campu->Telefono }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2" onclick="modalActualizar({{ $campu->IdCampus }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                            onclick="eliminar({{ $campu->IdCampus }})"><i
                                                class="fas fa-trash-alt"></i></button>
                                        <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2"><i
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
        <div class="modal fade" id="ModalCampus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <form id="formCampus" name="formCampus">
                            <div class="form-group">
                                <label for="">Nombre del campus</label>
                                <input type="text" name="pNombre" class="form-control" id="pNombre"
                                    placeholder="Escriba el nombre">
                                <label for="">Sede</label>
                                <input type="text" name="pSede" class="form-control" id="pSede"
                                    placeholder="Escriba la sede">
                                <label for="">Dirección del campus</label>
                                <input type="text" name="pDireccion" class="form-control" id="pDireccion"
                                    placeholder="Escriba la dirección">
                                <label for="">Teléfono del campus</label>
                                <input type="number" name="pTelefono" class="form-control" id="pTelefono"
                                    placeholder="Escriba teléfono">
                                <input type="hidden" name="id" id="id" value="">
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
        $('#crearCampus').click(function() {
            $('#tituloModal').text("Registrar Campus");
            $('#btnGuardar').show();
            $('#btnActualizar').hide();
            $('#formCampus').trigger("reset");
            $('#ModalCampus').modal('show');
        });
        //Mandar a guardar los datos
        $('#btnGuardar').click(function(e) {
            e.preventDefault();
            $(this).html('Save');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formCampus').serialize(),
                url: "{{ route('campus.guardar') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formCampus').trigger("reset");
                    $('#ModalCampus').modal('hide');
                    swal_success();
                    windows.reload();
                },
                error: function(data) {
                    swal_error();
                    $('#btnGuardar').html('Error');
                }
            });
        });
        //Funcion del Modal Actualizar
        function modalActualizar(campus){
            console.log(campus);
        }
        //Funcion para eliminar
        function eliminar(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {idCampus : id},
                        url: "{{ route('campus.delete') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
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
