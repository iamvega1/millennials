<?php include(HTML_DIR . 'overall/header.php'); ?>
<body>
<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="iniEnc">
	<div class="mbr-section__container container mbr-section__container--isolated">
        <div class="row">
            <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2">
            <div class="modal-content">

             <div id="title_aviso_enc"></div>

             <div class="modal-header">
               <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
               <h4 style="color:#384d53;"><span class="glyphicon glyphicon-th-list"></span> Crear Encuesta</h4>
             </div>
             <div class="modal-body">
               <div role="form" onkeypress="return runScriptinit(event)">
                 <div class="form-group">
                   <label for="nom_encuesta"><span class="glyphicon glyphicon-file"></span> Nombre de la encuesta </label>
                   <input type="text" class="form-control" id="nom_encuesta" placeholder="Nombre">
                 </div>
                 <button type="button" style="width: 200px; margin: auto;" class="btn btn-primary btn-block btn-flat" onclick="iniEncuesta()"><span class="glyphicon glyphicon-send"></span> Crear</button>
               </div>
             </div>
             <div class="modal-footer">
               <!--<button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
               <p>¿No estás registrado? <a data-toggle="modal" data-target="#Registro">Registrate!</a></p>-->
               <!-- <p>Contraseña <a data-toggle="modal" data-target="#Lostpass">perdida?</a></p> -->
             </div>
           </div>
          </div>
        </div>
    </div>
</section>

<section class="mbr-section mbr-after-navbar" id="iniPreg" style="display: none;" style="padding-top: 20px;">
	<div class="mbr-section__container container mbr-section__container--isolated">
        <a id="btnTerminar" class="mbr-buttons__link btn btn-primary btn-lg" onclick="verEncuesta();">Terminar Encuesta</a>
        <div class="row">
            <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2">
            <div class="modal-content">

             <div id="title_aviso_preg"></div>

             <div class="modal-header">
               <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
               <div style="display: flex; justify-content: space-between;">
               		<h4 style="color:#384d53;"><span class="glyphicon glyphicon-th-list"></span> Crear Pregunta</h4>
               		<h4 style="color:#384d53;" id="title_encuesta"></h4>
               </div>
               
             </div>
             <div class="modal-body">
               <div role="form">
                 <div class="form-group">
                   <label for="nom_encuesta"><span class="glyphicon glyphicon-file"></span> Escriba una pregunta </label>
                   <input type="text" onkeyup ="return runScriptNewPreg(event)" class="form-control" id="preg" style="margin-bottom: 5px;" placeholder="Pregunta">
                   <div style="display: flex;justify-content: space-around;">
                   		<input type="text" data-toggle="tooltip" title="Da un enter para agregar la siguiente respuesta" class="form-control" id="res" onkeyup="return runScriptNewRes(event)" style="width: 50%;" placeholder="Respuesta">
                   		<label class="labelTipo" onchange="return runScriptChangeTipo(event)">
  		               		<select class="selectTipo" name="tipoRes" id="tipoRes">
  		                   	<option value="1">Simple  </option>
  		                   	<option value="2">Multiple</option>
  		                   	<option value="3">Prioridad</option>
  		                  </select>
		                  </label>
                   </div>
                 </div>
               </div>
             </div>
             <div class="modal-footer">
             	
               <div class="pregunta">              	
               		<h4 id="txtPreg"></h4>
	               	<div id="respuestas">   
	               		<div class="radio">
	               			<input type="radio">
	               			<label for="" class="label"></label>
	               		</div>           		
	               	</div>
	               	<div id="divDrag" style="display: none;">
	               		<div style="display: flex">
	               			<div style="width: 50%;">
	               				<table>
		               				<tr>
		               					<td>Arrastra los elementos</td>
		               				</tr>
		               				<tr>
		               					<td>
		               						<div id="lstResDrag" class="list-group">
		               							<label class="list-group-item label" style="color: black;">&nbsp;</label>
		               						</div>
		               					</td>
		               				</tr>
	               				</table>
		               		</div>
		               		<div style="width: 50%">
		               			<table id="tblRes">
		               				<tr>
		               					<td>Agregalos aqui</td>
		               				</tr>
		               				<tr>
		               					<td style="border: 1px solid #303F9F; height: 200px;">&nbsp;</td>
		               				</tr>
		               			</table>
		               		</div>
	               		</div>
	               	</div>
               </div>

               <button type="button" id="btnAgregar" style="width: 200px; margin: auto; display: none;" class="btn btn-primary btn-block btn-flat" onclick="goPregunta()"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</button>

             </div>
           </div>
          </div>
        </div>
    </div>
</section>


<?php include(HTML_DIR . 'overall/footer.php'); ?>
<script src="views/app/js/encuesta.js"></script>
</body>
</html>
