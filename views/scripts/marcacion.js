
function init() {
    camara();
    

    $("#formulario").on("submit",function(e){
        guardarEditar(e);	
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Asigna los valores de latitud y longitud a los inputs
            $('#latitud').val(position.coords.latitude);
            $('#longitud').val(position.coords.longitude);
        }, function(error) {
            // Maneja errores
            console.error("Error Code = " + error.code + " - " + error.message);
        });
    } else {
        console.error("Geolocation is not supported by this browser.");
    }

    //Cargamos los items al select proveedor
    $.post('../ajax/registro.php?op=selectPersonal', function(r){
        $('#idpersona').html(r);
        $('#idpersona').selectpicker('refresh');
       
    });
}

const contraints = {
    audio : false,
    video : {
     width:1280, height:720
    }
};

async function camara() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(contraints);
        handleSucces(stream);  
      } catch (error) {
          $("#mensaje").html("No se puede acceder a la camara web");
      }
    
}

function handleSucces(stream){
    window.stream = stream;
    video.srcObject = stream;
}




async function guardarEditar(e) {
    e.preventDefault(); // Evita la acción predeterminada

    var video = $("#video")[0];
    var canvas = $("#foto")[0];
    let context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, 420, 340);

    // Convertir canvas a Blob de manera asíncrona
    const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/png'));

    // Crear FormData y añadir el Blob
    var formData = new FormData($('#formulario')[0]);
    formData.append('imagen', blob, 'imagen.png');
    
    // Validar si la latitud está vacía
    let latitud = formData.get('latitud');
    let longitud = formData.get('longitud');
    if (!latitud || latitud.trim() === '' || !longitud || longitud.trim() === '')  {
        Swal.fire({
            title: 'Error',
            text: 'Debe llenar todos los parámetros, incluyendo Ubicacion.',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        return; // Detiene la ejecución de la función
    }

    // Proceder con la llamada AJAX después de tener el Blob y validar la latitud
    $.ajax({
        url: '../ajax/marcacion.php?op=guardar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            if (datos.includes("registrada") || datos.includes("actualizada")) {
                Swal.fire({
                    title: 'Operación Exitosa',
                    text: datos,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();                        
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
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

}


init()

