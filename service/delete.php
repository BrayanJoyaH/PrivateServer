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

$cid = "";
$type = "";
$file = "";


if (isset($_GET['cid']) && isset($_GET['type']) && !empty($_GET['cid']) && !empty($_GET['type'])) {
    
    $cid = $_GET['cid'];
    $type = $_GET['type'];

    if (!fileExist($cid)) {

        echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
        die();

    }

    if (!validateFileUser($cid)) {
        echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
        die();
    }

    $file = getInfo('name', 'files', 'cid', $cid);

} else {

    if(isset($_POST['cid']) && !empty($_POST['cid']) && isset($_POST['type']) && !empty($_POST['type'])) {

        $cid = $mysqli->real_escape_string($_POST['cid']); 
        $type = $mysqli->real_escape_string($_POST['type']);

        $archivo = getInfo('url', 'files', 'cid', $cid);
        

        if (fileExist($cid)) {

            if(validateFileUser($cid)) {

                $index = getInfo('fld', 'files', 'cid', $cid);

                if (file_exists($archivo)) {

                    deleteFile($cid, $type);
                }
                

                if ($index == "root") {
                    echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'home.php">';
                    die();
                } else {
                    echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'page.php?cid='.$index.'">';
                    die();
                }
                
            } else {

                echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
                die();
            }


        } else {

            echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
            die();
        }
    }  else {

        echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
        die();
    }   


}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="theme-color" content="<?php echo THEMECOLOR ?>">
    <meta name="description" content="<?php echo APPDESCRIPTION ?>">
    <meta name="og:description" content="<?php echo APPDESCRIPTION ?>"/>
    <meta name="og:url" content="<?php echo SERVERURL ?>"/>
    <meta name="og:title" content="<?php echo APPTITLE ?>"/>
    <meta name="og:image" content="<?php echo SERVERURL ?>img/private_server.png"/>
    <!--    ICONS PAGE  -->
    <link id="favicon" rel="shortcut icon" href="<?php echo SERVERURL ?>/img/favicon/1x/favicon.png" type="image/png"/>
    <link rel="apple-touch-icon" sizes="194x194" href="<?php echo SERVERURL ?>img/apple-touch-icon.png" type="image/png"/>
    <!--    NORMALIZE.CSS v8.0.1    -->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>css/normalize.css">
    <!--    CUSTOM CSS    -->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>css/login.css">
    <!--    ICONS fontawesome-free  -->
    <link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
    <!--    SCRIPT JS    --->
    <title>Delete File</title>
</head>
<body>
    <div class="icons">
        <?php 
        
        for ($i=0; $i < 20; $i++) { 
            $selector = rand(1,3);
            $rand = rand(160, 240);
            $dimension = $rand."px";
            switch ($selector) {
            case 1:
                echo "<i class='icon fas fa-lock' style='top: -$dimension'></i>";
                break;
            case 2:
                echo "<i class='icon fas fa-server' style='top: -$dimension'></i>";
                break;
            case 3:
                echo "<i class='icon fas fa-user' style='top: -$dimension'></i>";
                break;
            
            default:
                break;
            }
        }
         ?>
    </div>

    <header>Private <strong>Server<i class="fas fa-lock"></i></strong></header>

    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
        <p class="title-login"><i class="fas fa-user-times"></i>Do you want delete this file?</p>
        <p><small><?php echo $file; ?></small></p>
        <input type="hidden" name="cid" id="cid" required value="<?php echo $cid ?>">
        <input type="hidden" name="type" id="type" required value="<?php echo $type ?>">
        <input type="submit" value="Delete" id="Delete">
    </form> 

    <footer>
        <a href="<?php echo MYWEB ?>" target="_BLANK">
            <i>Brayan Joya</i>&nbsp;&copy;
        </a>
    </footer>
</body><body>
    
</body>
</html>
