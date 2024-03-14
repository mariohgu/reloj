<?php

require_once "../config/global.php";

date_default_timezone_set('America/Lima');

$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Configurar la codificación de caracteres
if (!$conexion->set_charset(DB_ENCODE)) {
    printf("Error cargando el conjunto de caracteres %s: %s\n", DB_ENCODE, $conexion->error);
    exit();
}

if (mysqli_connect_errno()) {
    // Si hay un error de conexión, muestra el mensaje de error y termina la ejecución
    printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
    exit();
} else {
    // Si la conexión es exitosa, muestra un mensaje de éxito
    echo "Conexión a la base de datos " . DB_NAME . " exitosa. \n";
    echo date("Y-m-d H:i:s");
    $formatter = new IntlDateFormatter(
        'es_ES',
        IntlDateFormatter::FULL,
        IntlDateFormatter::SHORT,
        'America/Lima', // O la zona horaria que necesites
        IntlDateFormatter::GREGORIAN,
        "EEEE, d 'de' MMMM 'de' Y, HH:mm" // Patrón personalizado
    );
    echo $formatter->format(new DateTime());


}

// Aquí puedes agregar más código para trabajar con la base de datos
// Por ejemplo, realizar consultas SQL, etc.

// No olvides cerrar la conexión cuando ya no sea necesaria
$conexion->close();

?>