var tabla;
var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    
//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e)
	{
		guardarEditar(e);	
	})
   
    
}

//función limpiar
function limpiar() {
    $('#nombre').val('');
    $('#num_documento').val('');
    $('#tipo_documento').val('');
    $('#direccion').val('');
    $('#telefono').val('');
    $('#email').val('');
    $('#fecha_nac').val(today);
    $('#codigo_interno').val('');
    $('#idpersona').val('');

    	//Obtenemos la fecha actual
        

}

//función mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
        $('#tipo_documento').val('DNI');
        $('#tipo_documento').selectpicker('refresh');
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
        $('#btnAgregar').show();
        
    }
}

//functión cancelarForm
function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

//function listar
function listar() {
    tabla = $('#tblListado').DataTable({
        'aProcessing': true, //activamos el procesamiento del datatable
        'aServerSide': true, //paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [            
            'copyHtml5',
            'excel',
            'pdf'
        ],
        
        'ajax': {
            url: '../ajax/persona.php?op=listarC',
            type: 'get',
            dataType: 'json',
            error: function e() {
                console.log(e.responseText);
            }},
        'bDestroy': true,
        'iDisplayLength': 5, //paginación
        'order': [[0, 'desc']], //ordenar (columns, orden)
        extends: lenguajeDataTable()
    });
}

function guardarEditar(e) {
    e.preventDefault(); //No se activará la acción predeterminado del evento
    $('#btnGuardar').prop('disabled', true);
    var formData = new FormData($('#formulario')[0]);

    $.ajax({
        url: '../ajax/persona.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            if (datos.includes("registrada") || datos.includes("actualizada") ) {
				Swal.fire({
                    title: 'Operacion exitosa',
                    text: datos,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        mostrarForm(false);
	          			listar();
                    }
                });
                
            }
            else {         

				Swal.fire({
                    title: 'Error en la operacion',
                    text: datos,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        mostrarForm(false);
	          			listar();
                    }
                });
            }
            
        }
    });

    limpiar();
}

function mostrar(idpersona) {
    $.post('../ajax/persona.php?op=mostrar', {idpersona: idpersona}, function(data){
        data= JSON.parse(data);
        console.log(data);
        mostrarForm(true);

        $('#nombre').val(data.nombre);
        $('#tipo_documento').val(data.tipo_documento);
        $('#tipo_documento').selectpicker('refresh');
        $('#num_documento').val(data.num_documento);
        $('#fecha_nac').val(data.fecha_nac);
        $('#codigo_interno').val(data.codigo_interno);
        $('#direccion').val(data.direccion);
        $('#telefono').val(data.telefono);
        $('#email').val(data.email);
        $('#idpersona').val(data.idpersona);
        

    });
}

//Funcion para eliminar registros
function eliminar(idpersona) {
    Swal.fire({
        title: '¿Está seguro de eliminar al cliente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('../ajax/persona.php?op=eliminar', {idpersona: idpersona}, function(e){
                Swal.fire(
                    'Eliminado!',
                    e,
                    'success'
                );
                tabla.ajax.reload();
            });
        }
    });
}


init();