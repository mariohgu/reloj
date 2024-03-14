<?php

//Incluímos inicialmente la conexión a la base de datos
require '../config/conexion.php';

Class Permiso
{
    //Implementamoa nuestro constructor
    public function __construct(){

    }

    //Implementar para listar todos los registros
    public function listar(){
        $sql = "SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }
}


?>