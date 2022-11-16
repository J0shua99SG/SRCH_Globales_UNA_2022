@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de edificios</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearEdificio"><i
                            class="fas fa-plus"></i>Agregar edificio</button></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Edificio</th>
                            <th>Campus</th>
                            <th>Nombre</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($edificios as $edificio)
                            <tr id="row-{{ $edificio->IdEdificio }}">
                                <td id="id">{{ $edificio->IdEdificio }}</td>
                                @foreach ($campus as $campu)
                                @if ($edificio->IdCampus == $campu->IdCampus)
                                <td >{{ $campu->Nombre }}
                                <input type="hidden" id="IdCampus" value="{{$edificio->IdCampus}}"></td>
                                @endif
                                @endforeach
                                <td id="Nombre">{{ $edificio->Nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                        onclick="modalActualizar({{ $edificio->IdEdificio }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                        onclick="eliminar({{ $edificio->IdEdificio }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $edificio->IdEdificio }})"><i
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
    <div class="modal fade" id="ModalEdificio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="cerrar()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEdificio" name="formEdificio">
                    <div class="form-group">
                        <select class="form-control" name="pIdCampus" id="pIdCampus" onchange="validarCampus()" required>
                                <option value="">Seleccione un Campus</option>
                            @foreach ($campus as $campu)
                                <option value="{{ $campu->IdCampus }}">{{ $campu->Nombre }}</option>
                            @endforeach
                        </select>
                        <small style="color: red" id="pCampusValidation"></small></br>
                      
                        <br>
                        <label for="">Edificio</label>
                        <input type="text" name="pNombre" class="form-control" id="pNombre"
                            placeholder="Escriba el nombre" onkeyup="validarNombre()" maxlength="50">
                            <small style="color: red" id="pNombreValidation">Campo requerido</small></br>
                        <input type="hidden" name="pIdEdificio" id="pIdEdificio" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="cerrar()">Cerrar</button>
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
        title: 'Ocurrió un error!',
        showConfirmButton: true,
    })
}

//Modal de guardar
$('#crearEdificio').click(function() {
    $('#tituloModal').text("Registrar Edificio");
    $('#btnGuardar').show();
    $('#btnActualizar').hide();
    $('#formEdificio').trigger("reset");
    $('#ModalEdificio').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
    $( "#pIdCampus" ).prop( "disabled", false );
    limpiarValidaciones();
});

//Mandar a guardar los datos
$('#btnGuardar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formEdificio').serialize(),
        url: "{{ route('edificios.guardar') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formEdificio').trigger("reset");
            $('#ModalEdificio').modal('hide');
            swal_success();
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(data) {
            swal_error();
            validarNombre();
            validarCampus()
        }
    });
});

//Validaciones 

function validarNombre() {
    nombre = document.formEdificio.pNombre;
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
        document.getElementById('pNombreValidation').innerHTML= 'Campo requerido';
        document.getElementById('pNombreValidation').style.color= 'red';
        nombre.style.border = "1px solid red";
        $('#pNombreValidation').show();
        return false;
    }
    return true;
}

function validarCampus(){
    campus = $("#pIdCampus");

    if (campus.val() == "") {
        $("#pCampusValidation").text("Debe seleccionar un Campus...");
        $("#pCampusValidation").style.color = "red";
    } else {
        $("#pCampusValidation").text("");
    }
}

//Limpiar validaciones
function limpiarValidaciones() {
    nombre = document.formEdificio.pNombre;
    nombre.style.border = "1px solid #d1d3e2";
    $('#pNombreValidation').hide();
    $("#pCampusValidation").text("");
}

//Funcion del Modal Detalles
function modalDetalle(IdEdificio) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdEdificio;
    let campus = $("#"+ row_id + " " + "#IdCampus").val();
    let nombre = $("#"+ row_id + " " + "#Nombre").text();

    $('#tituloModal').text("Detalles del Edificio");
    $('#btnGuardar').hide();
    $('#btnActualizar').hide();
    $('#formEdificio').trigger("reset");
    $('#ModalEdificio').modal('show');

    $( "#pNombre" ).prop( "disabled", true );
    $( "#pIdCampus" ).prop( "disabled", true );

    $('#pIdEdificio').val(IdEdificio);
    $('#pNombre').val(nombre);
    $('#pIdCampus').val(campus);

    limpiarValidaciones();
}
//Funcion del Modal Actualizar
function modalActualizar(IdEdificio) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdEdificio;
    let campus = $("#"+ row_id + " " + "#IdCampus").val();
    let nombre = $("#"+ row_id + " " + "#Nombre").text();

    $('#tituloModal').text("Actualizar Edificio");
    $('#btnGuardar').hide();
    $('#btnActualizar').show();
    $('#formEdificio').trigger("reset");
    $('#ModalEdificio').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
    $( "#pIdCampus" ).prop( "disabled", false );
    $('#pIdEdificio').val(IdEdificio);
    $('#pNombre').val(nombre);
    $('#pIdCampus').val(campus);

    limpiarValidaciones();
}
//Mandar a actualizar los datos
$('#btnActualizar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formEdificio').serialize(),
        url: "{{ route('edificios.update') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formEdificio').trigger("reset");
            $('#ModalEdificio').modal('hide');
            swal_success();
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(data) {
            swal_error();
            validarNombre();
            validarCampus();
            
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
                    pIdEdificio: id
                },
                url: "{{ route('edificios.delete') }}",
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
