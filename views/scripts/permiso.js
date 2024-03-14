var tabla;

//función que se ejecuta al inicio
function init() {
    mostrarForm(false);
    listar();
}

//función mostrar formulario
function mostrarForm(flag) {
    if (flag) {
        $('#listadoRegistros').hide();
        $('#formularioRegistros').show();
        $('#btnGuardar').prop('disabled', false);
        $('#btnAgregar').hide();
    }else{
        $('#listadoRegistros').show();
        $('#formularioRegistros').hide();
        $('#btnAgregar').hide();
    }
}

//function listar
function listar() {
    tabla = $('#tblListado').DataTable({
        'aProcessing': true, //activamos el procesamiento del datatable
        'aServerSide': true, //paginacion y filtrado realizados por el servidor
        dom: 'Bfrtip', //definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        'ajax': {
            url: '../ajax/permiso.php?op=listar',
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

init();