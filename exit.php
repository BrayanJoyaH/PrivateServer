<?php  

session_start();

require 'config/config.php';

$_SESSION['id'] = null;
$_SESSION['id_tipo'] = null;
$_SESSION['user'] = null;
$_SESSION['name'] = null;
$_SESSION['email'] = null;
$_SESSION['image'] = null;

session_destroy();

echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
die();


?>