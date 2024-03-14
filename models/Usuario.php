<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Usuario
{
    //Implementamoa nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = "INSERT INTO usuario (nombre, tipo_documento, num_documento, direccion, telefono, email, fecha_nac, cargo, login, clave, imagen, condicion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1')";
        $params = [$nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $clave, $imagen];
        $types = "sssssssssss"; // Ajusta los tipos según tus necesidades específicas y la definición de tu base de datos.

        $idusuarioNew = ejecutarConsulta_retornarIDPreparada($sql, $params, $types);

        if ($idusuarioNew <= 0) {
            return false; // Si la inserción del usuario falla, termina la función.
        }

        $sw = true;
        for ($num_elementos = 0; $num_elementos < count($permisos); $num_elementos++) {
            $sql_detalle = "INSERT INTO permisousuario (idusuario, idpermiso) VALUES (?, ?)";
            $params_detalle = [$idusuarioNew, $permisos[$num_elementos]];
            $types_detalle = "ii"; // Asumiendo que tanto idusuario como idpermiso son enteros.

            if (!ejecutarConsultaPreparada($sql_detalle, $params_detalle, $types_detalle)) {
                $sw = false;
                break; // Si falla alguna inserción de permisos, detiene el proceso.
            }
        }

        return $sw;
    }


    //Implementamos un método para editar registros
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $clave, $imagen, $permisos)
    {
        // Actualización de la información del usuario
        $sql = "UPDATE usuario 
                SET nombre=?, tipo_documento=?, num_documento=?,
                    direccion=?, telefono=?, email=?, fecha_nac=?,
                    cargo=?, login=?, clave=?, imagen=? 
                WHERE idusuario=?";
        $params = [$nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $fecha_nac, $cargo, $login, $clave, $imagen, $idusuario];
        $types = "sssssssssssi"; // Asume que todos los parámetros son strings excepto idusuario que es un entero
        ejecutarConsultaPreparada($sql, $params, $types);

        // Eliminación de todos los permisos asignados
        $sqldel = "DELETE FROM permisousuario WHERE idusuario = ?";
        ejecutarConsultaPreparada($sqldel, [$idusuario], "i");

        // Inserción de los nuevos permisos
        $sw = true;
        $sql_detalle = "INSERT INTO permisousuario(idusuario, idpermiso) VALUES (?, ?)";
        foreach ($permisos as $idpermiso) {
            if (!ejecutarConsultaPreparada($sql_detalle, [$idusuario, $idpermiso], "ii")) {
                $sw = false;
                break; // Si falla alguna inserción de permisos, detiene el proceso.
            }
        }

        return $sw;
    }


    //Implementamos un método para desactivar el usuario
    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='0' WHERE idusuario=?";
        return ejecutarConsultaPreparada($sql, [$idusuario], "i");
    }

    //Implementamos un método para activar usuario
    public function activar($idusuario)
    {
        $sql = "UPDATE usuario SET condicion='1' WHERE idusuario=?";
        return ejecutarConsultaPreparada($sql, [$idusuario], "i");
    }

    //Implementamos un método para listar un registro
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario=?";
        return ejecutarConsultaSimpleFilaPreparada($sql, [$idusuario], "i");
    }

    //Implementar para listar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }

    //Implemenar un método para listos los permisos marcados
    public function listarMarcados($idusuario)
    {
        $sql = "SELECT * FROM permisousuario WHERE idusuario = ?";
        return ejecutarConsultaPreparada($sql, [$idusuario], "i");
    }

    //Función para verificar el acceso al sistema
    public function verificar($login)
    {
        $sql = "SELECT idusuario, nombre, tipo_documento, num_documento, telefono, email, cargo, imagen, login, clave
            FROM usuario 
            WHERE login = ? 
                AND condicion = '1'";
        $params = [$login];
        $types = "s"; // Indicamos que el parámetro es una cadena (string).

        return ejecutarConsultaPreparada($sql, $params, $types);
    }



    public function listarU()
    {
        $sql = "SELECT * FROM usuario WHERE condicion='1'";
        return ejecutarConsulta($sql);
    }
}


?>