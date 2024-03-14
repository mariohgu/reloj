<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Marcacion
{
    //Implementamoa nuestro constructor
    public function __construct()
    {

    }
    public function insertar($idpersonal, $fecha_hora, $latitud, $longitud, $imagen)
    {
        $sql = "INSERT INTO ingreso (idpersonal, fecha_hora, latitud, longitud, imagen, estado) VALUES (?, ?, ?, ?, ?, '1')";
        return ejecutarConsultaPreparada($sql, [$idpersonal, $fecha_hora, $latitud, $longitud, $imagen], 'issss');
    }

    //Implementamos un método para editar registros
    public function editar($idmedio, $medio)
    {
        $sql = "UPDATE medio_pago SET medio=? WHERE idmedio=?";
        return ejecutarConsultaPreparada($sql, [$medio, $idmedio], 'si');
    }

    //Implementamos un método para desactivar categorías
    public function desactivar($idmedio)
    {
        $sql = "UPDATE medio_pago SET condicion='0' WHERE idmedio=?";
        return ejecutarConsultaPreparada($sql, [$idmedio], 'i');
    }

    //Implementamos un método para activar categorías
    public function activar($idmedio)
    {
        $sql = "UPDATE medio_pago SET condicion='1' WHERE idmedio=?";
        return ejecutarConsultaPreparada($sql, [$idmedio], 'i');
    }

    //Implementamos un método para listar un registro
    public function mostrar($idmedio)
    {
        $sql = "SELECT * FROM medio_pago WHERE idmedio=?";
        return ejecutarConsultaSimpleFilaPreparada($sql, [$idmedio], 'i');
    }

    //Implementar para listar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM medio_pago";
        return ejecutarConsulta($sql);
    }

    //Implementar un mpétodo para listar los registros activos
    public function select()
    {
        $sql = "SELECT * FROM medio_pago WHERE condicion='1'";
        return ejecutarConsulta($sql);
    }
}


?>