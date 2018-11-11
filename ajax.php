<?php

if($_POST) {

  require('core/core.php');

  switch (isset($_GET['mode']) ? $_GET['mode'] : null) {
    case 'login':
      require('core/bin/ajax/goLogin.php');
      break;
    case 'encuesta':
      require('core/bin/ajax/goEncuesta.php');
      break;
    case 'reg':
      require 'core/bin/ajax/goReg.php';
      break;
    case 'userDelete':
      require 'core/bin/ajax/goUserDelete.php';
      break;
    case 'act':
      require 'core/bin/ajax/goUserActualizar.php';
      break;
    case 'encuestaVer':
      require 'core/bin/ajax/goEncuestaVer.php';
      break;
    case 'encDelete':
      require 'core/bin/ajax/goEncDelete.php';
      break;
    default:
      header('location: index.php');
      break;
  }
} else {
  header('location: index.php');
}

?>
