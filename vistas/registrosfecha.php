<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  
  header("location: login.html");

}else{
  
require 'header.php';

if($_SESSION['pacientes']==1 || $_SESSION['trabajo social']==1){

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
                          <h1 class="box-title">Consulta de pacientes por fecha </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" name="fechainicio" id="fechainicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" name="fechafin" id="fechafin" value="<?php echo date("Y-m-d"); ?>">
                        </div>

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="text-transform: uppercase;">
                          <thead>
                            <th>Fecha ingreso</th>
                            <th>Fecha atención</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Embarazo</th>
                            <th>N° gesta</th>
                            <th>Motivo atención</th>
                            <th>N° Seguro Popular</th>
                            <th>Sala</th>
                            <th>Médico</th>
                            <th>Recepcionista</th>
                            <th>Turno</th>
                            <th>Observaciones</th> 
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Fecha ingreso</th>
                            <th>Fecha atención</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Sexo</th>
                            <th>Embarazo</th>
                            <th>N° gesta</th>
                            <th>Motivo atención</th>
                            <th>N° Seguro Popular</th>
                            <th>Sala</th>
                            <th>Médico</th>
                            <th>Recepcionista</th>
                            <th>Turno</th>
                            <th>Observaciones</th>
                          </tfoot>
                        </table>
                    </div>
                    
                    <!--Fin registro -->
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
?>

<script type="text/javascript" src="scripts/registrosfecha.js"></script>

<?php

}

ob_end_flush();

?>