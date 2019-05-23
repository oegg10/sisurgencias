<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

Class Permiso{

    //Constructor
    public function __construct(){

    }

    //Método para listar todos los permisos
    public function listar(){

        $sql = "SELECT * FROM permisos";

        return ejecutarConsulta($sql);

    }

}

?>