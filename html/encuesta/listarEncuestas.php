<?php include(HTML_DIR . 'overall/header.php'); ?>
<link rel="stylesheet" href="views/media/css/dataTables.bootstrap.css">

<body>

<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="iniEnc">
  <div class="mbr-section__container container mbr-section__container--isolated">
    <div class="row">    
      <div class="modal-content">

        <div id="_messages_info_enc_"></div> <!-- Div Sin utilidad aparente -->

        <div class="modal-header">
          <center><h1 style="color:#FF5733;"><span class="glyphicon glyphicon-wrench"></span>  Administrador de encuestas</h1>
          </center>
          <h2 style="color:#FF5733;"> Lista de encuestas</h2>
        </div>

        <div class="container" style="width: 750px; margin: auto;">

          <table id="tblListEnc" class="table table-striped table-bordered" cellspacing="0">
            <thead>
              <tr>
                <th>Encuesta</th>
                <th>Creado por</th>
                <th>Fecha de creación</th>
                <?php if(isset($_SESSION['mostar'])){
                    echo '<th>Gráfica</th>';
                  }               
                ?>
                <th></th>
              </tr>
            </thead>

            <tbody>

              <?php  
                $encuesta = new Encuestas();
                $listEncuestas = $encuesta->obt_encuestas();
                foreach ($listEncuestas as $enc) {
              ?>
              <tr>               
                <td><?php echo $enc->nombre ?></td>
                <td><?php echo $enc->usuario ?></td>
                <td><?php echo $enc->fecha_crea->format('Y-m-d'); ?></td>
                <?php 
                  if(isset($_SESSION['mostar'])){
                    echo '<td><a href="?view=encuesta&action=verPreg&encuesta='.$enc->nombre.'" class="btn btn-primary" style="border-radius: 10px;" role="button">Ver</a></td>';
                  }               
                ?>
                <td><?php echo '<a href="?view=encuesta&action=contestar&encuesta='.$enc->nombre.'" class="btn btn-primary" style="border-radius: 10px; role="button">Contestar</a>' ?></td>
              </tr>

              <?php } // Fin del ciclo foreach 
              ?>

            </tbody>

            
          </table>

        </div>

      </div>
    </div>
  </div>
</section>

<?php 
  if(isset($_SESSION['mostar'])){
    include(HTML_DIR . '/public/confirmEnc.html');
  }               
?>

<?php include(HTML_DIR . 'overall/footer.php'); ?>

<script src="views/media/js/jquery.dataTables.js"></script>
<script src="views/media/js/dataTables.bootstrap.js"></script>
<script src="views/media/js/dataTables.jqueryui.js"></script>
<script src="views/app/js/lstEnc.js"></script>
<?php 
  if(isset($_SESSION['mostar'])){
    echo '<script src="views/app/js/deleteEnc.js"></script>';
  }               
?>

 
</script>
</body>
</html>