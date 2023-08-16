<?php  
session_start();

require 'config/config.php';
require 'funcs/conexion.php';
require 'funcs/funcs.php';

$activate = "";

if(isset($_GET['id']) && isset($_GET['token'])) {

	$id = $_GET['id'];
	$token = $_GET['token'];

	$activate = validateIdToken($id, $token);

} else {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
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
	<!--	ICONS PAGE	-->
	<link id="favicon" rel="shortcut icon" href="<?php echo SERVERURL ?>/img/favicon/1x/favicon.png" type="image/png"/>
	<link rel="apple-touch-icon" sizes="194x194" href="<?php echo SERVERURL ?>img/apple-touch-icon.png" type="image/png"/>
	<!--    NORMALIZE.CSS v8.0.1    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/normalize.css">
	<!--    CUSTOM CSS    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/login.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title>Activate | activate account</title>
	<style type="text/css">
		
		h3 {
			background-color: #49e;
			color: #fff;
			border-radius: 8px;
			padding: 14px 24px;

		}

		h3:hover {

			background-color: #27c;
		}

		a {
			text-decoration: none;

		}

	</style>
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

	<h1><?php echo $activate; ?></h1>
	<a href="<?php echo SERVERURL ?>index.php">
		<h3><i>Log in</i></h3>
	</a>


	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>
</body>
</html>