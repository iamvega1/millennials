<?php include(HTML_DIR . 'overall/header.php'); ?>

<body>

<section class="engine"><a rel="nofollow" href="#"><?php echo APP_TITLE ?></a></section>

<?php include(HTML_DIR . '/overall/topnav.php'); ?>

<section class="mbr-section mbr-after-navbar" id="iniEnc">
	<div class="mbr-section__container container mbr-section__container--isolated">
    <div class="row">    
      <div class="modal-content">

        <div id="_messages_info_users_"></div> <!-- Div Sin utilidad aparente -->

	      <div class="modal-header">
          <center><h1 style="color:#FF5733;"><span class="glyphicon glyphicon-wrench"></span> Grafica </h1>
          </center>
          <h2 style="color:#FF5733;"> <?php $id = $_GET['pregunta']; echo $id; ?> </h2>
        </div>

        <div class="container">          

        </div>

      </div>
    </div>
  </div>
</section>


<?php include(HTML_DIR . 'overall/footer.php'); ?>

</body>
</html>