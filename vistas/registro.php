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
                          <h1 class="box-title">Registro <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" style="text-transform: uppercase;">
                          <thead>
                            <th>Opciones</th>
                            <th>Estado</th>
                            <th>Fecha ingreso</th>
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
                            <th>Opciones</th>
                            <th>Estado</th>
                            <th>Fecha ingreso</th>
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
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST" autocomplete="off">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre (*):</label>
                            <input type="hidden" name="idpaciente" id="idpaciente">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del paciente" required autofocus onblur="may(this.value, this.id)">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Edad (*):</label>
                            <input type="number" class="form-control" name="edad" id="edad" maxlength="3" placeholder="Edad" required>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sexo (*):</label>
                            <select class="form-control select-picker" name="sexo" id="sexo" required onchange="habilitarSexo(this.value);">
                              <option value="" disabled selected>Sexo</option>
                              <option value="M">Masculino</option>
                              <option value="F">Femenino</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Embarazo:</label>
                            <select class="form-control select-picker" name="embarazo" id="embarazo" disabled="true" onchange="habilitarEmbarazo(this.value);">
                              <option value="0">No</option>
                              <option value="1">Si</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Numero de gesta:</label>
                            <input type="number" class="form-control" name="num_gesta" id="num_gesta" min="0" max="10" placeholder="N° gesta" disabled="true">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Motivo de la atención (*):</label>
                            <input type="text" class="form-control" name="diagnostico" id="diagnostico" maxlength="250" placeholder="Motivo de la atención" required onblur="may(this.value, this.id)">
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>N° Seguro Popular:</label>
                            <input type="text" class="form-control" name="num_segpop" id="num_segpop" maxlength="10" placeholder="Seguro Popular">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Sala:</label>
                            <input type="text" class="form-control" name="sala" id="sala" maxlength="3" placeholder="Sala" onblur="may(this.value, this.id)">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Médico:</label>
                            <input type="text" class="form-control" name="medico" id="medico" maxlength="60" placeholder="Médico" onblur="may(this.value, this.id)">
                            <input type="hidden" name="idusuario" id="idusuario">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Turno (*):</label>
                              <select class="form-control select-picker" name="turno" id="turno" required>
                                <option value="" disabled selected>Turno</option>
                                <option value="TM">MATUTINO</option>
                                <option value="TV">VESPERTINO</option>
                                <option value="TN A">NOCTURO A</option>
                                <option value="TN B">NOCTURNO B</option>
                                <option value="JA DIURNA">JORNADA ACUMULADA DIURNA</option>
                                <option value="JA NOCTURNA">JORNADA ACUMULADA NOCTURNA</option>
                              </select>
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="250" placeholder="Observaciones" onblur="may(this.value, this.id)">
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
<script>
		function habilitarSexo(value)
		{
			if(value=="F")
			{
				// habilitamos
        document.getElementById("embarazo").disabled=false;
        document.getElementById("num_gesta").disabled=true;
			}else if(value=="M" || value==false){
				// deshabilitamos
        document.getElementById("embarazo").disabled=true;
        document.getElementById("num_gesta").disabled=true;
			}
    }
    
    function habilitarEmbarazo(value)
		{
			if(value=="1")
			{
				// habilitamos
        document.getElementById("num_gesta").disabled=false;
			}else if(value=="0" || value==false){
				// deshabilitamos
        document.getElementById("num_gesta").disabled=true;
			}
		}
	</script>
<script type="text/javascript" src="scripts/registro.js"></script>

<?php

}

ob_end_flush();

?>