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

if (isset($_GET['cid']) && !empty($_GET['cid'])) {
	
	$cid = $_GET['cid'];

} else {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
}

if (!folderExist($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();

}

if (!validateFolderUser($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();
}

$ubicacion = "../".getInfo('url', 'folders', 'cid', $cid);
 
if(file_exists($ubicacion)) {

	$nombreOriginal = getInfo('name', 'folders', 'cid', $cid);
	$nametmp = $nombreOriginal.".zip";
	$token = getInfo('token', 'usuarios', 'id', $_SESSION['id']);

	$zip = new ZipArchive();

	$zip->open($nametmp,ZipArchive::CREATE);

	$zip->addEmptyDir($nombreOriginal);

	function listFolderFiles($dir, $nameFolder){

		global $zip;

	    $ffs = scandir($dir);
	    
	    unset($ffs[array_search('.', $ffs, true)]);
	    unset($ffs[array_search('..', $ffs, true)]);

	    // prevent empty ordered elements
	    if (count($ffs) < 1) {
	        return;
	    }

	    foreach($ffs as $ff) {

	    	if(is_file($dir.'/'.$ff)) {
	        	
	        	$link = $dir."/".$ff;
	        	$zip->addFile($link, $nameFolder."/".$ff);
	        }

	        if(is_dir($dir.'/'.$ff)) {

	        	$tmpnameFolder = $nameFolder."/".$ff;

	        	$zip->addEmptyDir($tmpnameFolder);
	        	listFolderFiles($dir.'/'.$ff, $tmpnameFolder);

	        } 
	        	
	    }
	}

	listFolderFiles($ubicacion, $nombreOriginal);	


	$zip->close();

	
	header("Content-Type: application/octet-stream");
	header("Content-disposition: attachment; filename=$nametmp");
	readfile($nametmp);

	unlink($nametmp);

}
?>