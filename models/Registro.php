<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

class Registro
{
    //Implementamoa nuestro constructor
    public function __construct()
    {

    }

    //Implementamos un método para insertar registros

    //Implementamos un método para desactivar categorías
    public function eliminar($idingreso)
    {
        $sql = "DELETE FROM ingreso WHERE idingreso=?";
        return ejecutarConsultaPreparada($sql, [$idingreso], "i");
    }

    public function mostrar($idingreso)
    {
        $sql = "SELECT i.idingreso, i.idpersonal, p.nombre as nombre, i.fecha_hora as fecha, i.latitud, i.longitud, i.imagen, i.estado
        FROM ingreso i
        INNER JOIN persona p ON i.idpersonal = p.idpersona  
        WHERE idingreso=?";
        return ejecutarConsultaSimpleFilaPreparada($sql, [$idingreso], 'i');
    }

    //Implementar para listar todos los registros
    public function listar()
    {
        $sql = "SELECT i.idingreso, i.idpersonal, p.nombre as nombre, i.fecha_hora as fecha, i.latitud, i.longitud, i.imagen, i.estado
        FROM ingreso i
        INNER JOIN persona p ON i.idpersonal = p.idpersona           
        ORDER BY fecha DESC;";
        return ejecutarConsulta($sql);
    }

    //Implementar un mpétodo para listar los registros activos
    public function rutaimagen($idingreso)
    {
        $sql = "SELECT imagen FROM ingreso WHERE idingreso=?";
        return ejecutarConsultaPreparada($sql, [$idingreso], "i");
    }
}


?>