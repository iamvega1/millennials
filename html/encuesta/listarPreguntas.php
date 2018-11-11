<?php include(HTML_DIR . 'overall/header.php'); ?>
<link rel="stylesheet" href="views/media/css/dataTables.bootstrap.css">

<body>

<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="iniEnc">
	<div class="mbr-section__container container mbr-section__container--isolated">
    <div class="row">    
      <div class="modal-content">

        <div id="_messages_info_preg_"></div> <!-- Div Sin utilidad aparente -->

	      <div class="modal-header">
          <center><h1 style="color:#FF5733;"><span class="glyphicon glyphicon-wrench"></span>  Gráficas</h1>
          </center>
          <h2 style="color:#FF5733;"> Lista de preguntas</h2>
        </div>

        <div class="container" style="width: 750px; margin: auto;">

          <table id="tblListPreg" class="table table-striped table-bordered" cellspacing="0">
            <thead>
              <tr>
                <th>Pregunta</th>
                <th>Ver</th>
              </tr>
            </thead>

            <tbody>

              <?php  
                $encuesta = new Encuestas();
                $id = $_GET['encuesta'];
                $encuesta->obt_encuesta($id);
                foreach ($encuesta->lst_preg as $preg) {
              ?>
              <tr>               
                <td><?php echo $preg->contenido ?></td>
                <td><?php echo '<a href="?view=encuesta&action=verGraf&pregunta='.$preg->id_pregunta.'" class="btn btn-primary" style="border-radius: 10px;  role="button">Ver</a>' ?></td>

              <?php } // Fin del ciclo foreach
              ?>

            </tbody>

            
          </table>

        </div>

      </div>
    </div>
  </div>
</section>


<?php include(HTML_DIR . 'overall/footer.php'); ?>

<script src="views/media/js/jquery.dataTables.js"></script>
<script src="views/media/js/dataTables.bootstrap.js"></script>
<script src="views/media/js/dataTables.jqueryui.js"></script>

</body>
</html>