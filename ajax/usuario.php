<?php

session_start();

require_once "../modelos/Usuario.php";

$user = new Usuario();

$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$sexo = isset($_POST["sexo"])? limpiarCadena($_POST["sexo"]):"";
$numempleado = isset($_POST["numempleado"])? limpiarCadena($_POST["numempleado"]):"";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$correo = isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$usuario = isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$password = isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
$imagen = isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";


switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            
            $imagen=$_POST["imagenactual"];

        }else{

            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }

        }

        //hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $password);
        
        if (empty($idusuario)) {

            //Comprobamos si ya existe el nombre de usuario
            $sql=mysqli_query($conexion,"SELECT usuario FROM usuarios WHERE usuario='$usuario'");
            $result=mysqli_fetch_array($sql);

            if (!$result) {
                
                //Si no existe se guarda el nuevo usuario
                $rspta = $user->insertar($nombre,$sexo,$numempleado,$telefono,$correo,$usuario,$clavehash,$imagen,$_POST['permiso']);
                echo $rspta ? "Usuario guardado" : "No se pudieron registrar todos los datos del usuario";

            }else{
                //Si existe se despliega un mensaje
                echo "El USUARIO ->> <strong>".$usuario."</strong> <<- ya se encuentra registrado";
            }

        }else{

            $rspta = $user->editar($idusuario,$nombre,$sexo,$numempleado,$telefono,$correo,$usuario,$clavehash,$imagen,$_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "El usuario no se pudo actualizar";

        }

        break;

    case 'desactivar':
    
        $rspta = $user->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado" : "El usuario no se pudo desactivar";
        
        break;

    case 'activar':

        $rspta = $user->activar($idusuario);
        echo $rspta ? "Usuario activado" : "El usuario no se pudo activar";
        
        break;

    case 'mostrar':

        $rspta = $user->mostrar($idusuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        
        break;

    case 'listar':

        $rspta = $user->listar();
        //Declaramos un array
        $data = Array();

        while ($reg=$rspta->fetch_object()) {
            $data[] = array(
                "0"=>($reg->condicion)?'<button class="btn btn-primary" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-primary" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                ' <button class="btn btn-success" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',

                "1"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>',
                "2"=>$reg->nombre,
                "3"=>$reg->sexo,
                "4"=>$reg->numempleado,
                "5"=>$reg->telefono,
                "6"=>$reg->correo,
                "7"=>$reg->usuario,
                "8"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
                "9"=>$reg->fechaalta

            );
        }

        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //Enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a visualizar
            "aaData"=>$data);

        echo json_encode($results);
        
        break;

    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //Obtener los permisos asignados al usuario
        $id = $_GET['id'];
        $marcados = $user->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->idpermiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object()) {

            $sw=in_array($reg->idpermiso,$valores)?'checked':'';
            echo '<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
        }


        break;

    case 'verificar':
        
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];

        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$clavea);

        $rspta=$user->verificar($logina, $clavehash);

        $fetch=$rspta->fetch_object();

        if (isset($fetch)) {
            
            //Declaramos las variables de sesión
            $_SESSION['idusuario']=$fetch->idusuario;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['usuario']=$fetch->usuario;
            $_SESSION['imagen']=$fetch->imagen;

            //Obtenemos los permisos del usuario
            $marcados = $user->listarmarcados($fetch->idusuario);

            //Declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object()) {
                
                array_push($valores, $per->idpermiso);

            }

            //Determinamos los accesos del usuario
            in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2,$valores)?$_SESSION['pacientes']=1:$_SESSION['pacientes']=0;
            in_array(3,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
            in_array(4,$valores)?$_SESSION['consultas']=1:$_SESSION['consultas']=0;
            in_array(5,$valores)?$_SESSION['trabajo social']=1:$_SESSION['trabajo social']=0;

        }

        echo json_encode($fetch);

        break;

    case 'salir':
        //Limpiamos las variables de sesión
        session_unset();
        //Destruimos la sesión
        session_destroy();
        //Redireccionamos al login
        header("location: ../index.php");
        break;
}

?>