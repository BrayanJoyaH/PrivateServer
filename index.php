<?php  
session_start();

require 'config/config.php';
require 'funcs/conexion.php';
require 'funcs/funcs.php';

$errors = array();
$user = "";

if (!empty($_POST)) {

	$user = $mysqli->real_escape_string($_POST['user']);
	$password = $mysqli->real_escape_string($_POST['password']);

	if(!isNullLogin($user, $password)) {

		$errors[] = login($user, $password);

	} else {

		$errors[] = "You must fill all the inputs";
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
	<title><?php echo TITLEINDEX ?></title>
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
		<p class="title-login"><i class="fas fa-server"></i>Log In</p>
		<input type="text" name="user" id="user" required autocomplete="off" placeholder="Username" value="<?php echo $user ?>">
		<input type="password" name="password" id="password" required autocomplete="off" placeholder="Password">
		<input type="submit" value="Login" id="login">	
		<?php  echo blockErrors($errors); ?>
	</form>	

	<hr>

	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>
</body>
</html>