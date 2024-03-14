<?php
if (strlen(session_id()) < 1) {
    session_start();
}

require_once '../models/Usuario.php';

$usuario = new Usuario();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$nombre = ucwords(strtolower($nombre));
$tipo_documento = isset($_POST["tipo_documento"]) ? limpiarCadena($_POST["tipo_documento"]) : "";
$num_documento = isset($_POST["num_documento"]) ? limpiarCadena($_POST["num_documento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? validarEmail(limpiarCadena($_POST["email"])) : "";
$fecha_nac = isset($_POST["fecha_nac"]) ? limpiarCadena($_POST["fecha_nac"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die();
        }
        if (!file_exists($_FILES["imagen"]["tmp_name"]) || !is_uploaded_file($_FILES["imagen"]["tmp_name"])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array(strtolower($ext), $allowed) && ($_FILES["imagen"]["size"] < 5000000)) { // 5MB máximo
                if ($_FILES["imagen"]["type"] == "image/jpg" || $_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png") {
                    $imagen = round(microtime(true)) . '.' . $ext;
                    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], "../Files/Usuarios/" . $imagen)) {
                        // Manejo de error
                        echo "Error al mover el archivo cargado.";
                    }
                }
            } else {
                // Manejo de extensión no permitida o archivo demasiado grande
                echo "Tipo de archivo no permitido o archivo demasiado grande.";
            }
        }


        //Hash SHA256 en la contraseña
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        if (empty($idusuario)) {
            $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $claveHash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario registrado " : "No se pudieron registrar todos los datos del usuario. ";
        } else {
            $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $claveHash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario actualizado " : "No se pudieron actualizar todos los datos del usuario. ";
        }
        break;
    case 'desactivar':
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;
    case 'activar':
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
        break;
    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $usuario->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil-alt"></i></button> ' .
                    '<button class="btn btn-danger" onclick="desactivar(' . $reg->idusuario . ')"><i class="fa fa-lock"></i></button>' :
                    '<button class="btn btn-warning" onclick="mostrar(' . $reg->idusuario . ')"><i class="fa fa-pencil-alt"></i></button> ' .
                    '<button class="btn btn-primary" onclick="activar(' . $reg->idusuario . ')"><i class="fa fa-unlock"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->num_documento,
                "3" => $reg->telefono,
                "4" => $reg->email,

                "5" => $reg->login,
                "6" => '<img src="../Files/Usuarios/' . $reg->imagen . '" height="50px" width="50px">',
                "7" => ($reg->condicion) ? '<span class="p-1 mb-2 bg-success text-white">Activado</<span>' : '<span class="p-1 mb-2 bg-danger text-white">Desactivado</<span>'
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
    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once '../models/Permiso.php';
        $permiso = new Permiso();
        $rpta = $permiso->listar();

        //Obtener los permisos asignados del usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarMarcados($id);

        //Declaramos el array para almacenar todos los pemrisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rpta->fetch_object()) {
            $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
            echo '<li><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $reg->idpermiso . '"> ' . $reg->nombre . '</li>';
        }
        break;
    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        // Ahora, la llamada a verificar solo necesita el login para obtener el hash de la contraseña almacenada
        $rspta = $usuario->verificar($logina);

        $fetch = $rspta->fetch_object();

        if (isset($fetch) && password_verify($clavea, $fetch->clave)) {
            // La verificación de la contraseña es exitosa, procedemos con el inicio de sesión

            // Regenera el ID de sesión después de un inicio de sesión exitoso
            session_regenerate_id(true);

            ini_set('session.cookie_secure', '1');
            ini_set('session.cookie_httponly', '1');

            // Declaración de variables de sesión
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // Obtenemos los permisos del usuario
            $marcados = $usuario->listarMarcados($fetch->idusuario);

            // Declaramos un array para almacenar todos los permisos marcados
            $valores = array();

            // Almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->idpermiso);
            }

            // Determinamos los accesos del usuario
            in_array(1, $valores) ? $_SESSION["escritorio"] = 1 : $_SESSION["escritorio"] = 0;
            in_array(2, $valores) ? $_SESSION["almacen"] = 1 : $_SESSION["almacen"] = 0;
            in_array(3, $valores) ? $_SESSION["compras"] = 1 : $_SESSION["compras"] = 0;
            in_array(4, $valores) ? $_SESSION["ventas"] = 1 : $_SESSION["ventas"] = 0;
            in_array(5, $valores) ? $_SESSION["servicio"] = 1 : $_SESSION["servicio"] = 0;
            in_array(6, $valores) ? $_SESSION["acceso"] = 1 : $_SESSION["acceso"] = 0;
            in_array(7, $valores) ? $_SESSION["consultac"] = 1 : $_SESSION["consultac"] = 0;
            in_array(8, $valores) ? $_SESSION["consultav"] = 1 : $_SESSION["consultav"] = 0;

            echo json_encode($fetch); // Usuario verificado correctamente
            break;

        } else {
            // La verificación de la contraseña falló
            echo 'null';
            break;


        }

    case 'salir':
        //Limpiamos las variables de sesion
        $_SESSION = array();
        //Destruimos la session

        // Si se desea invalidar la cookie de sesión también
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();

        //Redireccionamos al login
        header('Location: ../index.php');
        break;
}

?>