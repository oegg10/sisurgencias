<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  
  header("location: login.html");

}else{

require 'header.php';

if($_SESSION['pacientes']==1){

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
                          <h1 class="box-title">Pacientes consultados </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="text-transform: uppercase;">
                          <thead>
                            <th>Opcion</th>
                            <th>Egreso</th>
                            <th>Estado</th>
                            <th>Fecha ingreso</th>
                            <th>Hora atención</th>
                            <th>Minutos espera</th>
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
                            <th>Fecha egreso</th>
                            <th>Minutos consulta</th>
                            <th>Alta por:</th>
                            <th>Otro</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opcion</th>
                            <th>Egreso</th>
                            <th>Estado</th>
                            <th>Fecha ingreso</th>
                            <th>Hora atención</th>
                            <th>Minutos espera</th>
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
                            <th>Fecha egreso</th>
                            <th>Minutos consulta</th>
                            <th>Alta por:</th>
                            <th>Otro</th>
                          </tfoot>
                        </table>
                    </div>

                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                      <form name="formulario" id="formulario" method="POST" autocomplete="off">

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Nombre (*):</label>
                          <input type="hidden" name="idpaciente" id="idpaciente">
                          <input type="text" class="form-control" id="nombre" disabled="true">
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Fecha del egreso (*):</label>
                          <input type="datetime-local" class="form-control" name="fechaegreso" id="fechaegreso" required>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                          <label>Alta por: (*):</label>
                          <select class="form-control" name="altapor" id="altapor" required onchange="habilitarTraslado(this.value);">
                            <option value="" disabled selected>Alta</option>
                            <option value="Hospitalización">Hospitalización</option>
                            <option value="Consulta externa">Consulta externa</option>
                            <option value="Traslado a otra unidad">Traslado a otra unidad</option>
                            <option value="Domicilio">Domicilio</option>
                            <option value="Defunción">Defunción</option>
                            <option value="Fuga">Fuga</option>
                            <option value="Voluntad propia">Voluntad propia</option>
                          </select>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <label>Traslado a:</label>
                          <input type="text" class="form-control" name="otro" id="otro" maxlength="256" placeholder="Otra unidad" disabled="true">
                        </div>
                        
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"> Guardar</i></button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"> Cancelar</i></button>
                          </div>

                      </form>
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

<script type="text/javascript" src="scripts/consultados.js"></script>
<script>
		function habilitarTraslado(value)
		{
			if(value=="Traslado a otra unidad")
			{
				// habilitamos
        document.getElementById("otro").disabled=false;
			}else{
				// deshabilitamos
        document.getElementById("otro").disabled=true;
			}
    }
	</script>

<?php

}

ob_end_flush();

?>