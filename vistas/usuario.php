<?php

//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  
  header("location: login.html");

}else{

require 'header.php';

if($_SESSION['acceso']==1){
  
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
                          <h1 class="box-title">Usuario <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Num. Empleado</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Usuario</th>
                            <th>Foto</th>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Num. Empleado</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Usuario</th>
                            <th>Foto</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST" autocomplete="off">
                        
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre (*):</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="70" placeholder="Nombre y apellidos del usuario" required autofocus onblur="may(this.value, this.id)">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Sexo (*):</label>
                            <select class="form-control select-picker" name="sexo" id="sexo" required>
                              <option value="" disabled selected>Sexo</option>
                              <option value="M">Masculino</option>
                              <option value="F">Femenino</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Número de empleado (*):</label>
                            <input type="text" class="form-control" name="numempleado" id="numempleado" maxlength="10" placeholder="Número de empleado" required>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="15" placeholder="Teléfono">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Correo:</label>
                            <input type="email" class="form-control" name="correo" id="correo" maxlength="70" placeholder="Correo">
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Usuario (*):</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" maxlength="8" placeholder="Usuario" required>
                          </div>

                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Contraseña (*):</label>
                            <input type="password" class="form-control" name="password" id="password" maxlength="64" placeholder="Contraseña" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Permisos:</label>
                              <ul style="list-style: none;" id="permisos">
                              
                              </ul>
                          </div>
                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
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

<script type="text/javascript" src="scripts/usuario.js"></script>

<?php

}

ob_end_flush();

?>