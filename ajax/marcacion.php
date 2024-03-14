<?php
// if (strlen(session_id()) < 1) {
//     session_start();
// }

require_once '../models/Marcacion.php';

$marcacion = new Marcacion();

$idpersonal = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$latitud = isset($_POST["latitud"]) ? limpiarCadena($_POST["latitud"]) : "";
$longitud = isset($_POST["longitud"]) ? limpiarCadena($_POST["longitud"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$fecha_hora = date('Y-m-d H:i:s'); // Formato para fecha y hora

switch ($_GET["op"]) {
    case 'guardar':
        // if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        //     die();
        // }
        if (!file_exists($_FILES["imagen"]["tmp_name"]) || !is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array(strtolower($ext), $allowed) && ($_FILES["imagen"]["size"] < 5000000)) { // 5MB máximo
                if ($_FILES["imagen"]["type"] == "image/jpg" || $_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png") {
                    $imagen = round(microtime(true)) . '.' . $ext;
                    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], "../Files/Marcaciones/" . $imagen)) {
                        // Manejo de error
                        echo "Error al mover el archivo cargado.";
                    }
                }
            } else {
                // Manejo de extensión no permitida o archivo demasiado grande
                echo "Tipo de archivo no permitido o archivo demasiado grande.";
            }
        }
        $rspta = $marcacion->insertar($idpersonal, $fecha_hora, $latitud, $longitud, $imagen);
        echo $rspta ? "Marcacion registrada " : "No se pudieron registrar todos los datos del usuario. ";
        break;
}

?>