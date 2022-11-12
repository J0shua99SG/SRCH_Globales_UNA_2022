@extends('layout.master')
@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Departamentos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row-reverse" style="margin: 5px 0px;"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="crearDepartamento"><i
                            class="fas fa-plus"></i>Agregar Departamento</button></div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id Departamento</th>
                            <th>Nombre</th>
                            <th>Funciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departamento as $departamentos)
                            <tr id="row-{{ $departamentos->IdDepartamento }}">
                                <td id="id">{{ $departamentos->IdDepartamento }}</td>
                                <td id="Nombre">{{ $departamentos->Nombre }}</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2"
                                        onclick="modalActualizar({{ $departamentos->IdDepartamento }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2"
                                        onclick="eliminar({{ $departamentos->IdDepartamento }})"><i
                                            class="fas fa-trash-alt"></i></button>
                                    <button class="btn btn-sm btn-icon btn-outline-primary btn-circle mr-2" onclick="modalDetalle({{ $departamentos->IdDepartamento }})"><i
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
    <div class="modal fade" id="ModalDepartamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="formDepartamento" name="formDepartamento">
                    <div class="form-group">
                        <label for="">Nombre del Departamento</label>
                        <input type="text" name="pNombre" class="form-control" id="pNombre"
                            placeholder="Escriba el nombre" onkeypress="validation(this.value)" maxlength="10">
                        <small style="color: red"name="pNombreValidation" id="pNombreValidation">Campo requerido</small>
                        <input type="hidden" name="pIdDepartamento" id="pIdDepartamento" value="">
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
$('#crearDepartamento').click(function() {
    $('#tituloModal').text("Registrar Departamento");
    $('#btnGuardar').show();
    $('#btnActualizar').hide();
    $('#pNombreValidation').hide();
    $('#formDepartamento').trigger("reset");
    $('#ModalDepartamento').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
});
//Mandar a guardar los datos
$('#btnGuardar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formDepartamento').serialize(),
        url: "{{ route('departamentos.guardar') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formDepartamento').trigger("reset");
            $('#ModalDepartamento').modal('hide');
            swal_success();
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(data) {
            elem = document.formDepartamento.pNombre;
            if(elem.value == ""){
                elem.style.border = "1px solid red";
                $('#pNombreValidation').show();
            };
            swal_error();
        }
    });
});

//Validación: Cuando cambie el valor
function validation(val) {
  elem = document.formDepartamento.pNombre;

  if(elem.length != 0){
    elem.style.border = "1px solid #d1d3e2";
    $('#pNombreValidation').hide();
  };
}

//Funcion del Modal Detalles
function modalDetalle(IdDepartamento) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdDepartamento;
    let nombre = $("#"+ row_id + " " + "#Nombre").text();

    $('#tituloModal').text("Detalles del Departamento");
    $('#btnGuardar').hide();
    $('#btnActualizar').hide();
    $('#formDepartamento').trigger("reset");
    $('#ModalDepartamento').modal('show');

    $( "#pNombre" ).prop( "disabled", true );
    $('#pIdDepartamento').val(IdDepartamento);
    $('#pNombre').val(nombre);

}
//Funcion del Modal Actualizar
function modalActualizar(IdDepartamento) {
    //Capturamos los valores de la tabla
    row_id = "row-"+IdDepartamento;
    let nombre = $("#"+ row_id + " " + "#Nombre").text();


    $('#tituloModal').text("Actualizar Departamento");
    $('#btnGuardar').hide();
    $('#btnActualizar').show();
    $('#formDepartamento').trigger("reset");
    $('#ModalDepartamento').modal('show');
    $( "#pNombre" ).prop( "disabled", false );
    $('#pIdDepartamento').val(IdDepartamento);
    $('#pNombre').val(nombre);
}
//Mandar a actualizar los datos
$('#btnActualizar').click(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: $('#formDepartamento').serialize(),
        url: "{{ route('departamentos.update') }}",
        type: "POST",
        dataType: 'json',
        success: function(data) {
            $('#formDepartamento').trigger("reset");
            $('#ModalDepartamento').modal('hide');
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
                url: "{{ route('departamentos.delete') }}",
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
