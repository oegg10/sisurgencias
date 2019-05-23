<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

Class Registro{

    //Constructor
    public function __construct(){

    }

    //Método para insertar registros
    public function insertar($nombre,$edad,$sexo,$embarazo,$num_gesta,$diagnostico,$num_segpop,$sala,$medico,$idusuario,$turno,$observaciones){

        $sql = "INSERT INTO registros (nombre,edad,sexo,embarazo,num_gesta,diagnostico,num_segpop,sala,medico,idusuario,turno,observaciones,condicion) VALUES ('$nombre','$edad','$sexo','$embarazo','$num_gesta','$diagnostico','$num_segpop','$sala','$medico','$idusuario','$turno','$observaciones','1')";

        return ejecutarConsulta($sql);

    }

    //Método para editar registros
    public function editar($idpaciente,$nombre,$edad,$sexo,$embarazo,$num_gesta,$diagnostico,$num_segpop,$sala,$medico,$turno,$observaciones){

        $sql = "UPDATE registros SET nombre='$nombre',edad='$edad',sexo='$sexo',embarazo='$embarazo',num_gesta='$num_gesta',diagnostico='$diagnostico',num_segpop='$num_segpop',sala='$sala',medico='$medico',turno='$turno',observaciones='$observaciones' WHERE idpaciente='$idpaciente'";

        return ejecutarConsulta($sql);

    }

    //Método para cambiar la condicion del paciente
    public function atendido($idpaciente){

        $sql = "UPDATE registros SET condicion=0, hora_atencion = now() WHERE idpaciente='$idpaciente'";

        return ejecutarConsulta($sql);

    }

    //Método para cambiar la condicion del paciente
    public function noatendido($idpaciente){

        $sql = "UPDATE registros SET condicion=1 WHERE idpaciente='$idpaciente'";

        return ejecutarConsulta($sql);

    }

    //Método para mostrar los datos
    public function mostrar($idpaciente){

        $sql = "SELECT * FROM registros WHERE idpaciente='$idpaciente'";

        return ejecutarConsultaSimpleFila($sql);

    }

    //Método para listar a todos los pacientes
    public function listarAtendidos(){

        $sql = "SELECT r.idpaciente,r.fechahora_llegada,r.hora_atencion,TIMESTAMPDIFF(MINUTE,r.fechahora_llegada,r.hora_atencion) as minutosespera,r.nombre,r.edad,r.sexo,r.embarazo,r.num_gesta,r.diagnostico,r.num_segpop,r.sala,r.medico,r.idusuario,r.idusuario,u.nombre as recepcionista,r.turno,r.observaciones,r.condicion,r.fechaegreso,TIMESTAMPDIFF(MINUTE,r.hora_atencion,r.fechaegreso) as minutosconsulta,r.altapor,r.otro,r.egresocond FROM registros r INNER JOIN usuarios u ON r.idusuario=u.idusuario WHERE r.condicion = 0 ORDER BY r.idpaciente DESC";

        return ejecutarConsulta($sql);

    }

    //Método para listar a todos los pacientes
    public function listarNoAtendidos(){

        $sql = "SELECT r.idpaciente,r.fechahora_llegada,r.hora_atencion,r.nombre,r.edad,r.sexo,r.embarazo,r.num_gesta,r.diagnostico,r.num_segpop,r.sala,r.medico,r.idusuario,u.nombre as recepcionista,r.turno,r.observaciones,r.condicion FROM registros r INNER JOIN usuarios u ON r.idusuario=u.idusuario WHERE r.condicion = 1 ORDER BY r.idpaciente ASC";

        return ejecutarConsulta($sql);

    }

    //Método para egreso de paciente
    public function egreso($idpaciente,$fechaegreso,$altapor,$otro){
        
        //$sql = "UPDATE registros SET fechaegreso = now(), altapor = '$altapor', otro = '$otro', egresocond = 1 WHERE idpaciente='$idpaciente'";

        $sql = "UPDATE registros SET fechaegreso='$fechaegreso',altapor='$altapor',otro='$otro',egresocond=1 WHERE idpaciente='$idpaciente'";

        return ejecutarConsulta($sql);

    }

    //Método para no egresar al paciente
    public function noegreso($idpaciente){

        $sql = "UPDATE registros SET egresocond=0 WHERE idpaciente='$idpaciente'";

        return ejecutarConsulta($sql);

    }

    public function nopaciente(){

        echo "No hay idpaciente ";

    }

}

?>