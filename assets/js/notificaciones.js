
const notificacionSwal = (titleText, text, icon,confirmButtonText)=> {
    Swal.fire({
        title: titleText,
        text: text,
        icon: icon,     //warnining, error, success,info
        confirmButtonText: confirmButtonText
    })
}



function lenguajeDataTable() {
    $.extend(true, $.fn.dataTable.defaults, {
        responsive: true,
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "Copy": "Copiar",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            } }
    });
}

function confirmarDetalle(){
	var dialog = bootbox.alert("Se agregó correctamente");

	// Establecer un temporizador para cerrar el diálogo después de 1 segundo (1000 milisegundos)
	setTimeout(function(){
		dialog.modal('hide'); // Cierra el diálogo
	}, 800);

}