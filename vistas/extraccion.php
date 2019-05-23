<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  
  header("location: login.html");

}else{
  
require 'header.php';

if($_SESSION['consultas']==1){

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
                          <h1 class="box-title">Extracción en Excel de pacientes y usuarios </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="container">
                        <div>
                            <h2>Exportar Pacientes</h2>
                            <a href="../excel/reporte_pacientes.php"><input type="button" name="btnpacientes" class="btn btn-success" value="Excel Pacientes"></a>
                        </div>
                        <br>
                        <div>
                            <h2>Exportar Usuarios</h2>
                            <a href="#"><input type="button" name="btnusuarios" class="btn btn-info" value="Excel Usuarios"></a>
                        </div>
                    </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php

}else{
  require 'noacceso.php';
}

require 'footer.php';

}
/*../excel/reporte_usuarios.php*/
ob_end_flush();

?>