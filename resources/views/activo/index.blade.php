@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de activos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearActivo"><i
                            class="fas fa-plus"></i>Agregar activo</button></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Activo</th>
                            <th>Tipo Activo</th>
                            <th>Nombre</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activo as $activos)
                            <tr id="row-{{ $activos->IdActivo }}">
                                <td id="id">{{ $activos->IdActivo }}</td>
                                @foreach ($tipoactivos as $tipoactivo)
                                @if ($activos->IdTipoActivo == $tipoactivo->IdTipoActivo)
                                <td >{{ $tipoactivo->Nombre }}
                                <input type="hidden" id="IdTipoActivo" value="{{$tipoactivo->IdTipoActivo}}"></td>
                                @endif
                                @endforeach
                                <td id="Nombre">{{ $activos->Nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                        onclick="modalActualizar({{ $activos->IdActivo }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                        onclick="eliminar({{ $activos->IdActivo }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $activos->IdActivo }})"><i
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
    <div class="modal fade" id="ModalActivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="formActivo" name="formActivo">
                    <div class="form-group">
                        <label for="">Tipo del activo</label>
                        <select class="form-control" name="pIdTipoActivo" id="pIdTipoActivo">
                            <option value="1">Seleccionar tipo activo</option>
                            @foreach ($tipoactivos as $tipoactivo)
                                <option value="{{ $tipoactivo->IdTipoActivo }}">{{ $tipoactivo->Nombre }}</option>
                            @endforeach
                        </select>
                        <label for="">Nombre del activo</label>
                        <input type="text" name="pNombre" class="form-control" id="pNombre"
                            placeholder="Escriba el nombre" onkeyup="validation()" maxlength="50">
                        <small style="color: red" id="pNombreValidation">Campo requerido</small></br>
                        <input type="hidden" name="pIdActivo" id="pIdActivo" value="">
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
$('#crearActivo').click(function() {
    $('#tituloModal').text("Registrar Activo");
    $('#btnGuardar').show();
    $('#btnActualizar').hide();
    $('#formActivo').trigger("reset");
    $('#ModalActivo').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
    $( "#pIdTipoActivo" ).prop( "disabled", false );
});
//Mandar a guardar los datos
$('#btnGuardar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formActivo').serialize(),
        url: "{{ route('activo.guardar') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formActivo').trigger("reset");
            $('#ModalActivo').modal('hide');
            swal_success();
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(data) {
            swal_error();
          //  $('#btnGuardar').html('Error');
        }
    });
});

//Validación: Cuando cambie el valor y mostrar mensages
        function validation() {
            nombre = document.formActivo.pNombre;

            if(nombre.value != ""){
                if(nombre.value.length < 50){
                    nombre.style.border = "1px solid #d1d3e2";
                    $('#pNombreValidation').hide();
                }else{
                    document.getElementById('pNombreValidation').innerHTML= 'Solo se admiten 50 caracteres';
                    document.getElementById('pNombreValidation').style.color= 'gray';
                    $('#pNombreValidation').show();
                }
            }else{
                nombre.style.border = "1px solid red";
                $('#pNombreValidation').show();
                return false;
            }
            return true;
        }

        function limpiarValidaciones(){
            nombre = document.formActividad.pNombre;
            
            nombre.style.border = "1px solid #d1d3e2";

            $('#pNombreValidation').hide();
        }

//Funcion del Modal Detalles
function modalDetalle(IdActivo) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdActivo;
    let idTipoActivo = $("#"+ row_id + " " + "#IdTipoActivo").val();
    let nombre = $("#"+ row_id + " " + "#Nombre").text();

    $('#tituloModal').text("Detalles del Activo");
    $('#btnGuardar').hide();
    $('#btnActualizar').hide();
    $('#formActivo').trigger("reset");
    $('#ModalActivo').modal('show');

    $( "#pNombre" ).prop( "disabled", true );
    $( "#pIdTipoActivo" ).prop( "disabled", true );

    $('#pIdEdificio').val(IdActivo);
    $('#pNombre').val(nombre);
    $("#pIdTipoActivo").val(idTipoActivo);

}
//Funcion del Modal Actualizar
function modalActualizar(IdActivo) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdActivo;
    let idTipoActivo = $("#"+ row_id + " " + "#IdTipoActivo").val();
    let nombre = $("#"+ row_id + " " + "#Nombre").text();

    $('#tituloModal').text("Actualizar Activo");
    $('#btnGuardar').hide();
    $('#btnActualizar').show();
    $('#formActivo').trigger("reset");
    $('#ModalActivo').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
    $( "#pIdTipoActivo" ).prop( "disabled", false );
    $('#pIdActivo').val(IdActivo);
    $('#pNombre').val(nombre);
    $("#pIdTipoActivo").val(idTipoActivo);
}
//Mandar a actualizar los datos
$('#btnActualizar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formActivo').serialize(),
        url: "{{ route('activo.update') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formActivo').trigger("reset");
            $('#ModalActivo').modal('hide');
            swal_success();
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(data) {
            swal_error();
           // $('#btnActualizar').html('Error');
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
                    pIdActivo: id
                },
                url: "{{ route('activo.delete') }}",
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
