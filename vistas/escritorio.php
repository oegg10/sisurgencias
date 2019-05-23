<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  
  header("location: login.html");

}else{
  
require 'header.php';

if($_SESSION['escritorio']==1){

    require_once "../modelos/Consultas.php";
    $consulta = new Consultas();

    $rsptahoy = $consulta->totalregistroshoy();
    $reghoy = $rsptahoy->fetch_object();
    $totalh = $reghoy->totalhoy;

    $rsptagral = $consulta->totalregistros();
    $reggral = $rsptagral->fetch_object();
    $totalg = $reggral->totalgral;

    //Datos para mostrar el gráfico de barras de 10 días
    $registros10 = $consulta->registrosultimos_10dias();
    $fechas10 = '';
    $totales10 = '';
    while($regfecha10 = $registros10->fetch_object()){

        $fechas10 = $fechas10.'"'.$regfecha10->dia .'",';
        $totales10 = $totales10.$regfecha10->total .',';

    }

    //Quitamos la ultima coma (,)
    $fechas10=substr($fechas10, 0, -1);
    $totales10=substr($totales10, 0, -1);

    //Datos para mostrar el gráfico de barras de embarazadas 10 días
    $embarazos10 = $consulta->embarazosultimos_10dias();
    $fechasembarazos10 = '';
    $totalesembarazos10 = '';
    while($embarazosfecha10 = $embarazos10->fetch_object()){

        $fechasembarazos10 = $fechasembarazos10.'"'.$embarazosfecha10->dia .'",';
        $totalesembarazos10 = $totalesembarazos10.$embarazosfecha10->total .',';

    }

    //Quitamos la ultima coma (,)
    $fechasembarazos10=substr($fechasembarazos10, 0, -1);
    $totalesembarazos10=substr($totalesembarazos10, 0, -1);

    //Datos para mostrar el gráfico de barras de embarazo 12 meses
    $embarazos12 = $consulta->embarazadas_12meses();
    $fechasembarazo12 = '';
    $totalesembarazos12 = '';
    while($embarazosfecha12 = $embarazos12->fetch_object()){

        $fechasembarazo12 = $fechasembarazo12.'"'.$embarazosfecha12->fecha .'",';
        $totalesembarazos12 = $totalesembarazos12.$embarazosfecha12->total .',';

    }

    //Quitamos la ultima coma (,)
    $fechasembarazo12=substr($fechasembarazo12, 0, -1);
    $totalesembarazos12=substr($totalesembarazos12, 0, -1);

    //Datos para mostrar el gráfico de barras de 12 meses
    $registros12 = $consulta->registrosultimos_12meses();
    $fechas12 = '';
    $totales12 = '';
    while($regfecha12 = $registros12->fetch_object()){

        $fechas12 = $fechas12.'"'.$regfecha12->fecha .'",';
        $totales12 = $totales12.$regfecha12->total .',';

    }

    //Quitamos la ultima coma (,)
    $fechas12=substr($fechas12, 0, -1);
    $totales12=substr($totales12, 0, -1);

?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 class="box-title">Escritorio </h1>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h4 style="font-size: 17px;">
                                            <strong><?php echo $totalh; ?></strong>
                                        </h4>
                                        <p>Registros Hoy</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion info-box"></i>
                                    </div>
                                    <a href="registro.php" class="small-box-footer">Registros <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h4 style="font-size: 17px;">
                                            <strong><?php echo $totalg; ?></strong>
                                        </h4>
                                        <p>Registros Totales</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion info-box"></i>
                                    </div>
                                    <a href="consultados.php" class="small-box-footer">Registros <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Registros de los ultimos 10 días
                                    </div>
                                    <div class="box-body">
                                        <canvas id="registros10" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Embarazos ultimos 10 días
                                    </div>
                                    <div class="box-body">
                                        <canvas id="embarazos10" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Registros de los ultimos 12 meses
                                    </div>
                                    <div class="box-body">
                                        <canvas id="registros12" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Embarazos de los ultimos 12 meses
                                    </div>
                                    <div class="box-body">
                                        <canvas id="embarazos12" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--Fin registro -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php

}else{
  require 'noacceso.php';
}

require 'footer.php';
?>

        <script src="../public/js/Chart.min.js"></script>
        <script src="../public/js/Chart.bundle.min.js"></script>
        <script>
            //Gráfica de registros 10 días
            var ctx = document.getElementById("registros10").getContext('2d');
            var registros10 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $fechas10; ?>],
                    datasets: [{
                        label: '# Registros de los últimos 10 días',
                        data: [<?php echo $totales10; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            //Gráfica de embarazos 10 días
            var ctx = document.getElementById("embarazos10").getContext('2d');
            var embarazos10 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $fechasembarazos10; ?>],
                    datasets: [{
                        label: '# Embarazos de los últimos 10 días',
                        data: [<?php echo $totalesembarazos10; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            //Gráfica de embarazos 12 meses
            var ctx = document.getElementById("embarazos12").getContext('2d');
            var embarazos12 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $fechasembarazo12; ?>],
                    datasets: [{
                        label: '# Embarazos de los últimos 12 meses',
                        data: [<?php echo $totalesembarazos12; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            //Gráfica de 12 meses
            var ctx = document.getElementById("registros12").getContext('2d');
            var registros12 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php echo $fechas12; ?>],
                    datasets: [{
                        label: '# Registros de los últimos 12 meses',
                        data: [<?php echo $totales12; ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>

        <?php

}

ob_end_flush();

?>