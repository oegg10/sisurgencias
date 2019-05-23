<?php

session_start();

require_once "../modelos/Registro.php";

$registro = new Registro();

$idpaciente = isset($_POST["idpaciente"])? limpiarCadena($_POST["idpaciente"]):"";
$fechahora_llegada = isset($_POST["fechahora_llegada"])? limpiarCadena($_POST["fechahora_llegada"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$edad = isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
$sexo = isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$embarazo = isset($_POST["embarazo"])? limpiarCadena($_POST["embarazo"]):"";
$num_gesta = isset($_POST["num_gesta"])? limpiarCadena($_POST["num_gesta"]):"";
$diagnostico = isset($_POST["diagnostico"])? limpiarCadena($_POST["diagnostico"]):"";
$num_segpop = isset($_POST["num_segpop"])? limpiarCadena($_POST["num_segpop"]):"";
$sala = isset($_POST["sala"])? limpiarCadena($_POST["sala"]):"";
$medico = isset($_POST["medico"])? limpiarCadena($_POST["medico"]):"";
$idusuario = $_SESSION["idusuario"];
$apellidosr = isset($_POST["apellidosr"])? limpiarCadena($_POST["apellidosr"]):"";
$turno = isset($_POST["turno"])? limpiarCadena($_POST["turno"]):"";
$observaciones = isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        
        if (empty($idpaciente)) {
            
            $rspta = $registro->insertar($nombre,$edad,$sexo,$embarazo,$num_gesta,$diagnostico,$num_segpop,$sala,$medico,$idusuario,$turno,$observaciones);
            echo $rspta ? "Registro guardado" : "El registro no se pudo guardar";

        }else{

            $rspta = $registro->editar($idpaciente,$nombre,$edad,$sexo,$embarazo,$num_gesta,$diagnostico,$num_segpop,$sala,$medico,$turno,$observaciones);
            echo $rspta ? "Registro actualizado" : "El registro no se pudo actualizar";

        }

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

        $rspta = $registro->listarNoAtendidos();
        //Declaramos un array
        $data = Array();

        while ($reg=$rspta->fetch_object()) {
            $data[] = array(
                "0"=>($reg->condicion)?'<button class="btn btn-primary" onclick="mostrar('.$reg->idpaciente.')"><i class="fa fa-pencil"></i></button>'.
                ' <button class="btn btn-danger" onclick="atendido('.$reg->idpaciente.')"><i class="fa fa-check"></i></button>':
                '<button class="btn btn-primary" onclick="mostrar('.$reg->idpaciente.')"><i class="fa fa-pencil"></i></button>'.
                ' <button class="btn btn-success" onclick="noatendido('.$reg->idpaciente.')"><i class="fa fa-close"></i></button>',

                "1"=>($reg->condicion)?'<span class="label bg-red">Espera</span>':'<span class="label bg-green">Atendido</span>',
                "2"=>$reg->fechahora_llegada,
                "3"=>$reg->nombre,
                "4"=>$reg->edad,
                "5"=>$reg->sexo,
                "6"=>($reg->embarazo)?'<button class="btn btn-danger"><i class="fa fa-heartbeat"></i></button>': ' <button class="btn btn-primary"><i class="fa fa-close"></i></button>',
                "7"=>$reg->num_gesta,
                "8"=>$reg->diagnostico,
                "9"=>$reg->num_segpop,
                "10"=>$reg->sala,
                "11"=>$reg->medico,
                "12"=>$reg->recepcionista,
                "13"=>$reg->turno,
                "14"=>$reg->observaciones,             

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