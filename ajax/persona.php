<?php
if (strlen(session_id()) < 1) {
    session_start();
}

require_once '../models/Persona.php';

$persona = new Persona();

$idpersona = isset($_POST["idpersona"]) ? limpiarCadena($_POST["idpersona"]) : "";
$codigo_interno = isset($_POST["codigo_interno"]) ? sanitizarEntero(limpiarCadena($_POST["codigo_interno"])) : "";
$tipo_persona = isset($_POST["tipo_persona"]) ? limpiarCadena($_POST["tipo_persona"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$nombre = ucwords(strtolower($nombre));
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? sanitizarEntero(limpiarCadena($_POST["num_documento"])) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? sanitizarEntero(limpiarCadena($_POST["telefono"])) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$email = isset($_POST["email"]) ? validarEmail(limpiarCadena($_POST["email"])) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die();
        }

        if (empty($idpersona)) {
            if ($persona->existePersona($num_documento)) {
                echo "Ya existe registrado este numero de Documento $num_documento";
                break;
            } else {
                $rspta = $persona->insertar($codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email);
                echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
            }
        } else {
            $rspta = $persona->editar($idpersona, $codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email);
            echo $rspta ? "Pesona actualizada" : "Pesona no se pudo actualizar";
        }

        break;

    case 'mostrar':
        $rspta = $persona->mostrar($idpersona);
        echo json_encode($rspta);
        break;
    case 'listarC':
        $rspta = $persona->listarC();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->idpersona . ')"><i class="fa fa-pencil-alt"></i></button> ',
                "1" => $reg->nombre,
                "2" => $reg->num_documento,
                "3" => $reg->telefono,
                "4" => $reg->email
            );
        }

        $results = array(
            "sEcho" => 1, //información para el datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registro a visualizar
            "aaData" => $data
        );

        echo json_encode($results);

        break;
}

?>