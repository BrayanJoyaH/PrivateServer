<?php 

session_start();

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';
require '../funcs/files.php';

if (!validateSession()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();
} 

if (isset($_GET['cid']) && isset($_GET['type']) && !empty($_GET['cid']) && !empty($_GET['type'])) {
	
	$cid = $_GET['cid'];
	$type = $_GET['type'];

} else {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
}

if (!fileExist($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();

}

if (!validateFileUser($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();
}

$extension = "";

$ubicacion = getInfo('url', 'files', 'cid', $cid);
 
if( file_exists($ubicacion)) {

	$nombreOriginal = getInfo('name', 'files', 'cid', $cid);
	header("Content-Type: $extension");
	header("Content-Transfer-Encoding: Binary");
	header("Content-disposition: attachment; filename=$nombreOriginal");
	readfile($ubicacion);

}




?>