<?php

//Incluímos la conexión a la base de datos
require '../config/Conexion.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=Reporte_usuarios.xls");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel Usuarios</title>
</head>
<body>
    <div class="container">
        <h3 class="center">USUARIOS REGISTRADOS</h3>
        
        <table border="1">
            <thead>
                <th>NOMBRE</th>
                <th>SEXO</th>
                <th>NUM. DE EMPLEADO</th>
                <th>TELEFONO</th>
                <th>CORREO</th>
                <th>USUARIO</th>
                <th>FECHA DE ALTA</th>
                <th>CONDICION</th>
            </thead>
            <tbody>

            <?php
            error_reporting(0);

            $sql = "SELECT * FROM usuarios";
            $ejecutar = $conexion->query($sql);

            while ($filas = $ejecutar->fetch_row()) {
                
                echo "<tr>
                        <td>$filas[1]</td>
                        <td>$filas[2]</td>
                        <td>$filas[3]</td>
                        <td>$filas[4]</td>
                        <td>$filas[5]</td>
                        <td>$filas[6]</td>
                        <td>$filas[9]</td>
                        <td>$filas[10]</td>
                    </tr>";

            }

            ?>

            </tbody>
        </table>
    </div>
</body>
</html>