<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

Class Usuario{

    //Constructor
    public function __construct(){

    }

    //Método para insertar registros
    public function insertar($nombre,$sexo,$numempleado,$telefono,$correo,$usuario,$password,$imagen,$permisos){

        $sql = "INSERT INTO usuarios (nombre,sexo,numempleado,telefono,correo,usuario,password,imagen,condicion) VALUES ('$nombre','$sexo','$numempleado','$telefono','$correo','$usuario','$password','$imagen','1')";

        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "INSERT INTO  usuario_permiso(idusuario,idpermiso) VALUES ('$idusuarionew', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;

    }

    //Método para editar registros
    public function editar($idusuario,$nombre,$sexo,$numempleado,$telefono,$correo,$usuario,$password,$imagen,$permisos){

        $sql = "UPDATE usuarios SET nombre='$nombre',sexo='$sexo',numempleado='$numempleado',telefono='$telefono',correo='$correo',usuario='$usuario',password='$password',imagen='$imagen' WHERE idusuario='$idusuario'";

        ejecutarConsulta($sql);

        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";

        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {

            $sql_detalle = "INSERT INTO  usuario_permiso(idusuario,idpermiso) VALUES ('$idusuario', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }

        return $sw;

    }

    //Método para cambiar la condicion del paciente
    public function desactivar($idusuario){

        $sql = "UPDATE usuarios SET condicion=0 WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);

    }

    //Método para cambiar la condicion del paciente
    public function activar($idusuario){

        $sql = "UPDATE usuarios SET condicion=1 WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);

    }

    //Método para mostrar los datos
    public function mostrar($idusuario){

        $sql = "SELECT * FROM usuarios WHERE idusuario='$idusuario'";

        return ejecutarConsultaSimpleFila($sql);

    }

    //Método para listar a todos los pacientes
    public function listar(){

        $sql = "SELECT * FROM usuarios";

        return ejecutarConsulta($sql);

    }

    //Método para listar los permisos marcados
    public function listarmarcados($idusuario){

        $sql = "SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);

    }

    //Función para verificar el acceso al sistema
    public function verificar($login,$clave){

        $sql = "SELECT idusuario,nombre,usuario,password,imagen,condicion FROM usuarios WHERE usuario='$login' AND password='$clave' AND condicion='1'";

        return ejecutarConsulta($sql);

    }

}

?>