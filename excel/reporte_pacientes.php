<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Reporte_pacientes.xls");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel Pacientes</title>
</head>
<body>
    <div class="container">
        <h3 class="center">PACIENTES REGISTRADOS</h3>
        
        <table border="1">
            <thead>
                <th>FECHA Y HORA DE LLEGADA</th>
                <th>HORA DE ATENCION</th>
                <th>NOMBRE</th>
                <th>EDAD</th>
                <th>SEXO</th>
                <th>EMBARAZO</th>
                <th>NUMERO DE GESTA</th>
                <th>MOTIVO ATENCION</th>
                <th>NUM. SEGURO POPULAR</th>
                <th>SALA</th>
                <th>MEDICO</th>
                <th>RECEPCIONISTA</th>
                <th>TURNO</th>
                <th>OBSERVACIONES</th>
            </thead>
            <tbody>

            <?php
            error_reporting(0);

            $sql = "SELECT r.idpaciente,r.fechahora_llegada,r.hora_atencion,r.nombre,r.edad,r.sexo,r.embarazo,r.num_gesta,r.diagnostico,r.num_segpop,r.sala,r.medico,r.idusuario,u.nombre as recepcionista,r.turno,r.observaciones FROM registros r INNER JOIN usuarios u ON r.idusuario=u.idusuario ORDER BY r.fechahora_llegada DESC";
            $ejecutar = $conexion->query($sql);

            while ($filas = $ejecutar->fetch_row()) {
                
                echo "<tr>
                        <td>$filas[1]</td>
                        <td>$filas[2]</td>
                        <td>$filas[3]</td>
                        <td>$filas[4]</td>
                        <td>$filas[5]</td>
                        <td>$filas[6]</td>
                        <td>$filas[7]</td>
                        <td>$filas[8]</td>
                        <td>$filas[9]</td>
                        <td>$filas[10]</td>
                        <td>$filas[11]</td>
                        <td>$filas[13]</td>
                        <td>$filas[14]</td>
                        <td>$filas[15]</td>
                    </tr>";

            }

            ?>

            </tbody>
        </table>
    </div>
</body>
</html>