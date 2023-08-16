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
$folder = "";


if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    
    $cid = $_GET['cid'];

    if (!folderExist($cid)) {

        echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
        die();

    }

    if (!validateFolderUser($cid)) {
        echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
        die();
    }

    $folder = getInfo('name', 'folders', 'cid', $cid);

} else {

    if(isset($_POST['cid']) && !empty($_POST['cid'])) {

        $cid = $mysqli->real_escape_string($_POST['cid']); 
        $targetDir = "../".getInfo('url', 'folders', 'cid', $cid);

        if (folderExist($cid)) {

            if(validateFolderUser($cid)) {

                $index = getInfo('fld', 'folders', 'cid', $cid);

                if (file_exists($targetDir)) {

                    deleteFolder($cid);
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
    <title>Delete Folder</title>
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
        <p class="title-login"><i class="fas fa-user-times"></i>Do you want delete this folder?</p>
        <p><small><?php echo $folder; ?></small></p>
        <input type="hidden" name="cid" id="cid" required value="<?php echo $cid ?>">
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
