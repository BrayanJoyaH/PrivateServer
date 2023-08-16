<?php  
session_start();

require 'config/config.php';
require 'funcs/conexion.php';
require 'funcs/funcs.php';
require 'funcs/files.php';

if(!validateSessionAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

}

$email = "";
$name = "";
$user = "";

$errors = array();

if (!empty($_POST)) {

	$user = $mysqli->real_escape_string($_POST['user']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$confirmPassword = $mysqli->real_escape_string($_POST['confirmPassword']);
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = $mysqli->real_escape_string($_POST['email']);	
	$activo = 0;
	$type_user = 2;

	if (!isNullRegister($user, $password, $confirmPassword, $name, $email)) {

		if (!isEmail($email)) {

			$errors[] = "Invalid Email";
		}

		if (userExist($user)) {

			$errors[] = "The user entered already exists";
		}

		if (emailExist($email)) {

			$errors[] = "The email entered already exists";
		}

		if (!validatePassword($password, $confirmPassword)) {

			$errors[] = "Passwords do not match";
		}

		if (count($errors) == 0) {

			$pass_hash = hashPassword($password);
			$token = generateToken();
			
			$registro = registerUser($user, $pass_hash, $name, $email, $activo, $token, $type_user);

			if ($registro > 0) {

				$url = SERVERURL."activate.php?id=".$registro."&token=".$token;

				$subject = "Activate account private server";

				$font = " ";


				$styleB = 'style = "font-family: century gothic; font-variant: small-caps; padding: 34px 22px; background-color: #ededed; border-radius: 8px; text-align: center; font-size: 20px; font-weight: 200"';
				$styleA = 'style = "background-color: #49e; border-radius: 8px; color: #fff; padding: 12px 8px; text-decoration: none"';

				$body = "<div $styleB>Hello $name: <br><br><p>You are now register in private server.</p> <p>Now visit the next link to activate the account</p><br><br><a href='$url' $styleA>Activate account</a></div>";

				if (sendMail($email, $name, $subject, $body)) {
					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'pages/success.php?success=true&mail='.$email.'">';
					die();
				} else {
					$errors[] = "Failed to send email, but corret register contact the administrator";
				}

			} else {

				$errors[] = "Failed to register user";
			}
		}
		
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
	<title><?php echo TITLEREGISTER ?></title>
</head>
<body>
	<div class="icons">
		<?php 
		
		for ($i=0; $i < 20; $i++) { 
			$selector = rand(1,3);
			$rand = rand(200, 280);
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
		<p class="title-login"><i class="fas fa-server"></i>Register</p>
		<input type="text" name="name" id="name" required autocomplete="off" placeholder="Name" value="<?php echo $name ?>">
		<input type="text" name="user" id="user" required autocomplete="off" placeholder="Username" value="<?php echo $user ?>">
		<input type="email" name="email" id="email" required autocomplete="off" placeholder="Email" value="<?php echo $email ?>">
		<input type="password" name="password" id="password" required autocomplete="off" placeholder="Password">
		<input type="password" name="confirmPassword" id="confirmPassword" required autocomplete="off" placeholder="Confirm Password">
		<input type="submit" value="Register" id="Register">	
		<?php echo blockErrors($errors);  ?>
	</form>	

	<hr>

	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>
</body>
</html>