<?php

require_once "../models/Registro.php";

if (strlen(session_id()) < 1) {
	session_start();
}


$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$idingreso = isset($_POST["idingreso"]) ? limpiarCadena($_POST["idingreso"]) : "";

$registro = new Registro();

switch ($_GET["op"]) {
	case 'eliminar':
		// Obtener el nombre de la imagen desde la base de datos
		$imagen_consulta = $registro->rutaimagen($idingreso);
		$reg = $imagen_consulta->fetch_object();
		$imagen_consulta = $reg->imagen;
		$rutaImagen = "../Files/Marcaciones/" . $imagen_consulta;

		// Verificar si el archivo existe antes de intentar eliminarlo
		if (file_exists($rutaImagen)) {
			// Intentar eliminar el archivo
			if (unlink($rutaImagen)) {
				// Archivo eliminado con éxito, ahora eliminar el registro de la base de datos
				$rspta = $registro->eliminar($idingreso);
				echo $rspta ? "Registro anulado y archivo eliminado" : "Registro no se pudo anular";
			} else {
				// No se pudo eliminar el archivo
				echo "No se pudo eliminar el archivo de imagen, pero intentando anular el servicio...";
				$rspta = $registro->eliminar($idingreso);
				echo $rspta ? "Registro anulado" : "Registro no se pudo anular";
			}
		} else {
			// El archivo no existe, proceder a eliminar el registro de todos modos
			echo "Archivo no encontrado, procediendo a anular el servicio...";
			$rspta = $registro->eliminar($idingreso);
			echo $rspta ? "Registro anulado" : "Registro no se pudo anular";
		}
		break;


	case 'mostrar':
		$rspta = $registro->mostrar($idingreso);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $registro->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->idingreso . ')"><i class="fa fa-eye"></i></button> ' .
					'<button class="btn btn-danger" onclick="eliminar(' . $reg->idingreso . ')"><i class="fa fa-trash"></i></button>',
				"1" => $reg->nombre,
				"2" => $reg->fecha,
				"3" => $reg->latitud . ',' . $reg->longitud,
				"4" => '<img src="../Files/Marcaciones/' . $reg->imagen . '" height="50px" width="50px">',
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

	case 'selectPersonal':
		require_once "../models/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		echo '<option value="">--Seleccione--</option>';

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idpersona . '>' . $reg->num_documento . ' - ' . $reg->nombre . '</option>';
		}
		break;
}
?>