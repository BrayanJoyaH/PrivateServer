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


$archivo = getInfo('url', 'files', 'cid', $cid);

if ($type == "pdf") {
    
    $extension = "application/pdf";

} elseif ($type == "jpg" ) {

    $extension = "image/jpg";

} elseif ($type == "png") {

    $extension = "image/png";

} elseif ($type == "mp4") {

    $extension = "video/mp4";

} elseif ($type == "css") {

    $extension = "text/css";

} elseif ($type == "txt") {

    $extension = "text/plain";

} elseif ($type == "html") {

    $extension = "text/html";

} elseif ($type == "js") {

    $extension = "application/javascript";

} elseif ($type == "jpeg") {

    $extension = "image/jpeg";    
}

if( file_exists($archivo) ) {

    // Enviamos el PDF al cliente
    header("Content-type: $extension");
    header("Content-length: ".filesize($archivo));
    readfile($archivo);
}

?>



