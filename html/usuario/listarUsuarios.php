<?php include(HTML_DIR . 'overall/header.php'); ?>
<link rel="stylesheet" href="views/media/css/dataTables.bootstrap.css">

<body>

<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="iniEnc">
	<div class="mbr-section__container container mbr-section__container--isolated">
    <div class="row">    
      <div class="modal-content">

        <div id="_messages_info_users_"></div> <!-- Div Sin utilidad aparente -->

	      <div class="modal-header">
          <center><h1 style="color:#FF5733;"><span class="glyphicon glyphicon-wrench"></span> Área de administración</h1>
          </center>
          <h2 style="color:#FF5733;"> Lista de usuarios</h2>
        </div>

        <div class="container">

          <table id="tblListUsers" class="table table-striped table-bordered" cellspacing="0">
            <thead>
              <tr>
                <th class="align-middle">Usuario</th>
                <th>Rol</th>
                <th>Nombre</th>
                <th style="width: 75px;">Apellido paterno</th>
                <th style="width: 75px;">Apellido materno</th>
                <th>Contraseña</th>
                <th>fecha de creacion</th>
                <th>Fecha ultimo ingreso</th>
                <th>Codigo Postal</th>
                <th>Genero</th>
                <th>Fecha de nacimiento</th>
              </tr>
            </thead>

            <tbody>

              <?php  
                $user= new User();
                $listUser = $user->obt_usuarios();
                foreach ($listUser as $usr) {
              ?>
              <tr>
                <td><?php echo $usr->id ?></td>
                <td><?php echo $usr->rolDesc ?></td>
                <td><?php echo $usr->nombre ?></td>
                <td><?php echo $usr->ape_pat ?></td>
                <td><?php echo $usr->ape_mat ?></td>
                <td><?php echo $usr->pass ?></td>
                <td><?php echo $usr->fecha_crea->format('Y-m-d'); ?></td>
                <td><?php echo $usr->fecha_ult_ingreso ?></td>
                <td><?php echo $usr->codigo_postal ?></td>
                <td><?php echo $usr->sexoDesc ?></td>
                <td><?php echo $usr->fecha_nacimiento->format('Y-m-d'); ?></td>
              </tr>

              <?php } // Fin del ciclo foreach ?>

            </tbody>

            
          </table>

        </div>

      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="deleteComprobar" role="dialog">
   <div class="modal-dialog">

     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 style="color:red;"><span class="glyphicon glyphicon-exclamation-sign"></span> Comprobacion de seguridad</h4>
       </div>

       <div class="modal-body">
          <h5 style="color:red;"> Eliminar usuario</h5>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-rigth" onClick="deleteUser(this)" data-dismiss="modal"> Aceptar</button>
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
       </div>
     </div>
   </div>
 </div>
 <script src="views/app/js/reg.js"></script>


<div class="modal fade" id="AgregarUser" role="dialog">
  <div class="modal-dialog">

   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Registro</h4>
     </div>
     <div class="modal-body">
       <form role="form" >
         <div class="form-group">
           <label for="usrnick"><span class="glyphicon glyphicon-user"></span> Usuario o nick</label>
           <input type="text" class="form-control" id="user_reg" placeholder="Introduce un nombre de usuario">
         </div>
         <div class="form-group">
           <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Privilegios del usuario</label>
           <div style="width: 100%;height: 45px;">
             <label class="labelTipo" style="float: left;">
              <select class="selectTipo" name="tipoRol" id="tipoRol">
                <option value="1">Admin  </option>
                <option value="2">Encuestador</option>
                <option selected value="3">Encuestado</option>
              </select>
            </label>
           </div>
           
         </div>
         <div class="form-group">
           <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
           <input type="password" class="form-control" id="pass_reg" placeholder="Introduce tu contraseña">
         </div>
         <div class="form-group">
           <label for="psw_two"><span class="glyphicon glyphicon-eye-open"></span> Repite tu Contraseña</label>
           <input type="password" class="form-control" id="pass_reg_dos" placeholder="Introduce tu contraseña de nuevo">
         </div>
         <div class="form-group">
           <label for="usrname"><span class="glyphicon glyphicon-list-alt"></span> Nombre</label>
           <input type="text" class="form-control" id="user_name_reg" placeholder="Introduce tu nombre o nombres">
         </div>
         <div class="form-group">
           <label for="usrape"><span class="glyphicon glyphicon-list-alt"></span> Apellido paterno</label>
           <input type="text" class="form-control" id="user_ape_reg" placeholder="Introduce tu apellido paterno">
         </div>
         <div class="form-group">
           <label for="usrmat"><span class="glyphicon glyphicon-list-alt"></span> Apellido materno</label>
           <input type="text" class="form-control" id="user_mat_reg" placeholder="Introduce tu apellido materno">
         </div>
         <div class="form-group">
           <label for="usrmat"><span class="glyphicon glyphicon-envelope"></span> Codigo postal</label>
           <input type="number" class="form-control" id="user_cod_reg" placeholder="Introduce tu codigo postal">
         </div>
         <div class="form-group">
              <label type='date'><span class="glyphicon glyphicon-calendar"></span> Fecha de nacimiento</label>
              <input type="date" class="form-control" id="user_date_reg" placeholder="Introduce tu fecha de nacimiento">
          </div>
         
         <div class="form-group">
         <label type="text"><span class="glyphicon glyphicon-user"> Sexo:</span></label> 
          <div class="funkyradio">
            <div class="funkyradio-default">
                <input type="radio" name="sexo" value="0" id="rbtnm" />
                <label for="rbtnm">Hombre</label>
            </div>
            <div class="funkyradio-primary">
                <input type="radio" name="sexo" value="1" id="rbtnh" checked/>
                <label for="rbtnh">Mujer</label>
            </div>
          </div>
         </div>
         <div id="_messages_info_"></div>
         <button type="button" id="registrarme" onclick="goReg()" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Registrarme</button>
         <button type="button" id="btnActUser" onclick="goActualizar()" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button>
       </form>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
     </div>
   </div>
  </div>
  </div>
<?php include(HTML_DIR . 'overall/footer.php'); ?>

<script src="views/media/js/jquery.dataTables.js"></script>
<script src="views/media/js/dataTables.bootstrap.js"></script>
<script src="views/media/js/dataTables.jqueryui.js"></script>
<script src="views/app/js/configListUsers.js"></script>
<script type="text/javascript">
    
</script>
<script type="text/javascript">
 
</script>
</body>
</html>