var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e){
		guardarEditar(e);	
    });

    $('#imagenmuestra').hide();

    $.post('../ajax/usuario.php?op=permisos&id=', function(r){
        $('#permisos').html(r);
    });
}

//función limpiar
function limpiar() {
    $('#nombre').val('');    
    $('#num_documento').val('');
    $('#direccion').val('');
    $('#telefono').val('');
    $('#email').val('');
    $('#cargo').val('');
    $('#login').val('');
    $('#clave').val('');
    $("#imagenmuestra").attr('src','');
    $("#imagenactual").val('');
    $("#imagen").val('');
    $('#idusuario').val('');

    var now = new Date();
    var day = ('0' + now.getDate()).slice(-2);
    var month = ('0' + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + '-' + (month) + '-' + (day);
    $('#fecha_nac').val(today);
}

//función mostrar formulario
function mostrarForm(flag) {
    limpiar();

    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
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
            'excelHtml5',
            
            'pdf'
        ],
        'ajax': {
            url: '../ajax/usuario.php?op=listar',
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
        url: '../ajax/usuario.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            if (datos.includes("registrado") || datos.includes("actualizado") ) {
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
    	
	// formData.forEach(function(value, key) {
	// 	console.log(key + ": " + value);
	// });

    limpiar();
}

function mostrar(idusuario) {
    $.post('../ajax/usuario.php?op=mostrar', {idusuario: idusuario}, function(data){
        data = JSON.parse(data);
        mostrarForm(true);

        $('#nombre').val(data.nombre);    
        $('#tipo_documento').val(data.tipo_documento);
        $('#tipo_documento').selectpicker('refresh');
        $('#num_documento').val(data.num_documento);
        $('#direccion').val(data.direccion);
        $('#telefono').val(data.telefono);
        $('#fecha_nac').val(data.fecha_nac);
        $('#email').val(data.email);
        $('#cargo').val(data.cargo);
        $('#login').val(data.login);
        $('#clave').val(data.clave);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr('src', '../Files/Usuarios/' + data.imagen);
        $('#imagenactual').val(data.imagen);
        $('#idusuario').val(data.idusuario);
        $('#spanPass').show();
    });

    $.post('../ajax/usuario.php?op=permisos&id=' + idusuario, function(r){
        $('#permisos').html(r);
    });
}

//Funcion para desactivar registros
function desactivar(idusuario) {
    bootbox.confirm('¿Está seguro de desactivar el usuario?', function(result){
        if(result){
            $.post('../ajax/usuario.php?op=desactivar', {idusuario: idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//Funcion para activar registros
function activar(idusuario) {
    bootbox.confirm('¿Está seguro de activar el usuario?', function(result){
        if(result){
            $.post('../ajax/usuario.php?op=activar', {idusuario: idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init();