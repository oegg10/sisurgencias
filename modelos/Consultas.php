<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

Class Consultas{

    //Constructor
    public function __construct(){

    }


    //Método para listar a todos los pacientes
    public function consultasfecha($fechainicio,$fechafin){

        $sql = "SELECT r.fechahora_llegada,r.hora_atencion,r.nombre as paciente,r.edad,r.sexo,r.embarazo,r.num_gesta,r.diagnostico,r.num_segpop,r.sala,r.medico,u.nombre as recepcionista,r.turno,r.observaciones FROM registros r INNER JOIN usuarios u ON r.idusuario = u.idusuario WHERE DATE(r.fechahora_llegada)>='$fechainicio' AND DATE(r.fechahora_llegada)<='$fechafin'";

        return ejecutarConsulta($sql);

    }

    public function totalregistroshoy(){

        $sql = "SELECT IFNULL(count(fechahora_llegada),0) as totalhoy FROM registros WHERE DATE(fechahora_llegada)=curdate()";

        return ejecutarConsulta($sql);

    }

    public function totalregistros(){

        $sql = "SELECT IFNULL(count(fechahora_llegada),0) as totalgral FROM registros";

        return ejecutarConsulta($sql);

    }

    //Registros de 10 días
    public function registrosultimos_10dias(){

        //$sql = "SELECT CONCAT(DAY(fechahora_llegada),'-',MONTH(fechahora_llegada)) as fecha, IFNULL(count(fechahora_llegada),0) as total FROM registros GROUP BY fechahora_llegada ORDER BY fechahora_llegada DESC limit 0,10";

        $sql = "SELECT Mid(fechahora_llegada,9,2) as dia, COUNT(idpaciente) total FROM registros WHERE fechahora_llegada BETWEEN DATE_SUB(now(),INTERVAL 10 DAY) AND DATE_SUB(CURDATE(),INTERVAL 0 DAY) GROUP BY Mid(fechahora_llegada,9,2);";

        return ejecutarConsulta($sql);

    }

    //Registros de 12 meses
    public function registrosultimos_12meses(){

        $sql = "SELECT DATE_FORMAT(fechahora_llegada,'%M') as fecha, COUNT(nombre) AS total FROM registros GROUP BY MONTH(fechahora_llegada) ORDER BY fechahora_llegada DESC limit 0,12";

        return ejecutarConsulta($sql);

    }

    //Registros de embarazadas 10 días
    public function embarazosultimos_10dias(){

        $sql = "SELECT Mid(fechahora_llegada,9,2) as dia, COUNT(idpaciente) total FROM registros WHERE embarazo = 1 AND fechahora_llegada BETWEEN DATE_SUB(now(),INTERVAL 10 DAY) AND DATE_SUB(CURDATE(),INTERVAL 0 DAY) GROUP BY Mid(fechahora_llegada,9,2);";

        return ejecutarConsulta($sql);

    }

    public function embarazadas_12meses(){

        $sql = "SELECT DATE_FORMAT(fechahora_llegada,'%M') as fecha, COUNT(embarazo) AS total FROM registros WHERE embarazo = 1 GROUP BY MONTH(fechahora_llegada) ORDER BY fechahora_llegada DESC limit 0,12";

        return ejecutarConsulta($sql);

    }

}

?>