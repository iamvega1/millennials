<?php include(HTML_DIR . 'overall/header.php'); ?>

<body>
<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="content1-10">
    <div class="mbr-section__container container mbr-section__container--isolated">
        <div class="row">
            <div class="mbr-article mbr-article--wysiwyg col-sm-8 col-sm-offset-2">
            <div class="modal-content">

             
             <div class="modal-header">
               <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
               <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span> Iniciar Sesión</h4>
               <div id="_ajax_messages_"></div>
             </div>
             <div class="modal-body">
               <div role="form" onkeypress="return runScriptLogin(event)">
                 <div class="form-group">
                   <label for="usrname_or_email"><span class="glyphicon glyphicon-user"></span> Usuario </label>
                   <input type="text" class="form-control" id="user_login" placeholder="Introducir usuario">
                 </div>
                 <div class="form-group">
                   <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Contraseña</label>
                   <input type="password" class="form-control" id="pass_login" placeholder="Introducir Contraseña">
                 </div>
                 <div class="checkbox">
                   <label><input type="checkbox" value="1" id="session_login" checked>Recordarme</label>
                 </div>
                 

                 <button type="button" class="btn btn-default btn-success btn-block" onclick="goLogin()"><span class="glyphicon glyphicon-off"></span> Iniciar Sesión</button>
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

<?php include(HTML_DIR . 'overall/footer.php'); ?>
<script src="views/app/js/login.js"></script>

</body>
</html>
