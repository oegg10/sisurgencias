<?php

session_start();

require_once "../modelos/Registro.php";

$registro = new Registro();

$idpaciente = isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";

$fechaegreso = isset($_POST["fechaegreso"])? limpiarCadena($_POST["fechaegreso"]):"";
$altapor = isset($_POST["altapor"])? limpiarCadena($_POST["altapor"]):"";
$otro = isset($_POST["otro"])? limpiarCadena($_POST["otro"]):"";


switch ($_GET["op"]) {

    case 'egreso':

            $rspta = $registro->egreso($idpaciente,$fechaegreso,$altapor,$otro);
            echo $rspta ? "Egreso realizado" : "El egreso no se pudo realizar";
        
        break;
    
    case 'noegreso':
    
        $rspta = $registro->noegreso($idpaciente);
        echo $rspta ? "Registro actualizado" : "El registro no se pudo actualizar";
        
        break;
    
    case 'atendido':
    
        $rspta = $registro->atendido($idpaciente);
        echo $rspta ? "Registro actualizado" : "El registro no se pudo actualizar";
        
        break;

    case 'noatendido':

        $rspta = $registro->noatendido($idpaciente);
        echo $rspta ? "Registro actualizado" : "El registro no se pudo actualizar";
        
        break;

    case 'mostrar':

        $rspta = $registro->mostrar($idpaciente);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        
        break;

    case 'listar':

        $rspta = $registro->listarAtendidos();
        //Declaramos un array
        $data = Array();

        while ($reg=$rspta->fetch_object()) {
            $data[] = array(
                "0"=>($reg->condicion)?' <button class="btn btn-danger" onclick="atendido('.$reg->idpaciente.')"><i class="fa fa-check"></i></button>':
                ' <button class="btn btn-success" onclick="noatendido('.$reg->idpaciente.')"><i class="fa fa-close"></i></button>',

                "1"=>($reg->egresocond)?' <button class="btn btn-primary" onclick="noegreso('.$reg->idpaciente.')"><i class="fa fa-arrow-right"></i></button>':
                ' <button class="btn btn-danger" onclick="mostrar('.$reg->idpaciente.')"><i class="fa fa-pencil"></i></button>',

                "2"=>($reg->condicion)?'<span class="label bg-red">Espera</span>':'<span class="label bg-green">Atendido</span>',
                "3"=>$reg->fechahora_llegada,
                "4"=>$reg->hora_atencion,
                "5"=>$reg->minutosespera,
                "6"=>$reg->nombre,
                "7"=>$reg->edad,
                "8"=>$reg->sexo,
                "9"=>($reg->embarazo)?'<button class="btn btn-danger"><i class="fa fa-heartbeat"></i></button>': ' <button class="btn btn-primary"><i class="fa fa-close"></i></button>',
                "10"=>$reg->num_gesta,
                "11"=>$reg->diagnostico,
                "12"=>$reg->num_segpop,
                "13"=>$reg->sala,
                "14"=>$reg->medico,
                "15"=>$reg->recepcionista,
                "16"=>$reg->turno,
                "17"=>$reg->observaciones,
                "18"=>$reg->fechaegreso,
                "19"=>$reg->minutosconsulta,
                "20"=>$reg->altapor,
                "21"=>$reg->otro

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