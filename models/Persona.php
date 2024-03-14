<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Persona
{
    //Implementamoa nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros
    public function insertar($codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email)
    {
        $sql = "INSERT INTO persona (codigo_interno, tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, fecha_nac, email) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email];
        // Asumiendo que todos los parámetros son cadenas excepto donde se necesite otra consideración específica,
        // por ejemplo, fecha_nac podría requerir una conversión a formato de fecha si no se pasa como cadena.
        $types = "issssssss"; // Ajusta según los tipos reales de tus campos. Por ejemplo, si 'codigo_interno' es un entero, comienza con 'i'.

        return ejecutarConsultaPreparada($sql, $params, $types);

    }

    //Implementamos un método para editar registros
    public function editar($idpersona, $codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email)
    {
        $sql = "UPDATE persona SET codigo_interno=?, tipo_persona=?, nombre=?, tipo_documento=?, num_documento=?, direccion=?, telefono=?, fecha_nac=?, email=? WHERE idpersona=?";
        $params = [$codigo_interno, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $fecha_nac, $email, $idpersona];
        // Asumiendo que todos los campos son strings excepto idpersona que es un entero. Ajusta los tipos si es necesario, por ejemplo, si alguno de los campos debe ser tratado como un número o fecha.
        $types = "issssssssi"; // La cadena de tipos debe coincidir con los parámetros.

        return ejecutarConsultaPreparada($sql, $params, $types);
    }


    //Implementamos un método para desactivar categorías

    //Implementamos un método para listar un registro
    public function mostrar($idpersona)
    {
        $sql = "SELECT * FROM persona WHERE idpersona=?";
        return ejecutarConsultaSimpleFilaPreparada($sql, [$idpersona], "i");
    }

    //Implementar para listar todos los registros
    public function listarC()
    {
        $sql = "SELECT * FROM persona ORDER BY nombre ASC";

        return ejecutarConsulta($sql);
    }

    // Método para verificar si ya existe el medio de pago
    public function existePersona($num_documento)
    {
        $sql = "SELECT idpersona FROM persona WHERE num_documento=? LIMIT 1";
        $params = [$num_documento];
        $types = "s";
        $resultado = ejecutarConsultaPreparada($sql, $params, $types);
        return $resultado->num_rows > 0 ? true : false;
    }
}


?>