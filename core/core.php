<?php
/*
  EL NÚCLEO DE LA APLICACIÓN!
*/

session_start();

#Constantes de conexión
define('DB_HOST','localhost');
define('DB_USER','luis');
define('DB_PASS','vega');
define('DB_NAME','Millenials');

#Constantes de la APP
define('HTML_DIR','html/');
define('APP_TITLE','Millennials');
define('APP_COPY','Copyright &copy; ' . date('Y',time()) . ' Millennials Software.');
define('APP_URL','http://localhost/GitHub/iamvega1/');

#Estructura
require('core/models/class.Conexion.php');
require('core/models/class.Sexo.php');
require('core/models/class.Rol.php');
require('core/models/class.User.php');
require('core/models/class.Encuestas.php');
require('core/models/class.Preguntas.php');
require('core/models/class.RespPregunta.php');
require('core/bin/functions/Encrypt.php');
//require('core/bin/functions/Users.php');

//$users = Users();

?>
