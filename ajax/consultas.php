<?php

session_start();

require_once "../modelos/Consultas.php";

$consulta = new Consultas();


switch ($_GET["op"]) {

    case 'consultasfecha':

        $fechainicio = $_REQUEST["fechainicio"];
        $fechafin = $_REQUEST["fechafin"];

        $rspta = $consulta->consultasfecha($fechainicio,$fechafin);
        //Declaramos un array
        $data = Array();

        while ($reg=$rspta->fetch_object()) {
            $data[] = array(
                "0"=>$reg->fechahora_llegada,
                "1"=>$reg->hora_atencion,
                "2"=>$reg->paciente,
                "3"=>$reg->edad,
                "4"=>$reg->sexo,
                "5"=>($reg->embarazo)?'<button class="btn btn-danger"><i class="fa fa-heartbeat"></i></button>': ' <button class="btn btn-primary"><i class="fa fa-close"></i></button>',
                "6"=>$reg->num_gesta,
                "7"=>$reg->diagnostico,
                "8"=>$reg->num_segpop,
                "9"=>$reg->sala,
                "10"=>$reg->medico,
                "11"=>$reg->recepcionista,
                "12"=>$reg->turno,
                "13"=>$reg->observaciones            

            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        
        break;

}

?>