var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarForm(false);
	listar();
	
	//Cargamos los items al select cliente
	    //Cargamos los items al select proveedor
		$.post('../ajax/registro.php?op=selectPersonal', function(r){
			$('#idpersonalMostrar').html(r);
			$('#idpersonalMostrar').selectpicker('refresh');
		   
		});	
}

//Función limpiar
function limpiar(){
	$("#idpersonal").prop('selectedIndex', 0);
	$("#idpersonal").selectpicker('refresh');
	$("#idingreso").val("");
	$("#fecha_horaMostrar").val("");
	$("#coordenadasMostrar").val("");
	$("#imagenmostrar").attr("src","../Files/Marcaciones/sin_imagen.png");
}

//Función mostrar formulario
function mostrarForm(flag){
	limpiar();
	if (flag)
	{
		
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$('#formularioMostrar').hide();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		
	}
	else
	{
		$("#listadoregistros").show();
		$('#formularioMostrar').hide();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarForm(false);
}

//Función Listar
function listar(){
	tabla=$('#tbllistado').DataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/registro.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
		extends: lenguajeDataTable()
	});
}

function mostrar(idingreso){
	$('#formularioMostrar').show();
    $('#listadoregistros').hide();
	$.post("../ajax/registro.php?op=mostrar",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);	
		console.log(data);

		imagen_path = "../Files/Marcaciones/"+data.imagen;
		coordenadas = data.latitud+","+data.longitud;
		$("#idingreso").val(data.idingreso);
		$("#idpersonalMostrar").val(data.idpersonal);
		$("#idpersonalMostrar").selectpicker('refresh');
		$("#coordenadasMostrar").val(coordenadas);
		$("#imagenmostrar").attr("src",imagen_path);	
		$("#fecha_horaMostrar").val(data.fecha);

	
		
 	});
}

//Función para anular registros

function eliminar(idingreso) {
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
            $.post('../ajax/registro.php?op=eliminar', {idingreso: idingreso}, function(e){
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