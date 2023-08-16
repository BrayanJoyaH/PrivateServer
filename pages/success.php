<?php 

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';
require '../funcs/files.php';

if(isset($_GET['success']) && isset($_GET['mail']) && !empty($_GET['success']) && !empty($_GET['mail'])) {

	$success = $_GET['success'];
	$mail = $_GET['mail'];

	if ($success == "true") {
		
		$msg = "Registrated User, check your email $mail to activated the account";
	} else {

		$msg = "Could not register an account";
	}

} else {
	$msg = "Empty register";
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google" content="notranslate">
	<meta name="format-detection" content="telephone=no"/>
	<meta name="theme-color" content="#49e">
	<meta name="description" content="private_server - Brayan Joya">
	<meta name="og:description" content="private_server - Brayan Joya"/>
	<meta name="og:url" content="https://brayanjoya.000webhostapp.com/"/>
	<meta name="og:title" content="Brayan joya private web server"/>
	<meta name="og:image" content="https://brayanjoya.000webhostapp.com/private_server.png"/>
	<!--	ICONS PAGE	-->
	<link id="favicon" rel="shortcut icon" href="/img/favicon/1x/favicon.png" type="image/png"/>
	<link rel="apple-touch-icon" sizes="194x194" href="/apple-touch-icon.png" type="image/png"/>
	<!--    NORMALIZE.CSS v8.0.1    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/normalize.css">
	<!--    CUSTOM CSS    -->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/login.css">
	<!-- <link rel="stylesheet" href="css/elements.css"> -->
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="js/script.js"></script>
	<title>Success</title>
</head>
<body>
	<div class="icons">
		<?php 
		
		for ($i=0; $i < 20; $i++) { 
			$selector = rand(1,3);
			$rand = rand(160, 240);
			$medida = $rand."px";
			switch ($selector) {
			case 1:
				echo "<i class='icon fas fa-lock' style='top: -$medida'></i>";
				break;
			case 2:
				echo "<i class='icon fas fa-server' style='top: -$medida'></i>";
				break;
			case 3:
				echo "<i class='icon fas fa-user' style='top: -$medida'></i>";
				break;
			
			default:
				break;
			}
		}
		 ?>
	</div>

	<header>Private <strong>Server<i class="fas fa-lock"></i></strong></header>

	<h4><?php echo $msg; ?></h4>

	<footer>
		<a href="https://brayanjoya.github.io/Tarjeta/" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>
</body>
</html>