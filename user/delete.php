<?php 
session_start();

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';
require '../funcs/files.php';

if (!validateSessionAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 

$errors = array();
$email = "";
$id = "";
$auth = "";
$token = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (userExistIdToken($id, $token)) {
		$email = getInfo('correo', 'usuarios', 'id', $id);
		$auth = 1;
	} else {
		$errors[] = "User doesn't exist";
	}
 
} else {

	if(isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['auth']) && !empty($_POST['auth']) && isset($_POST['token']) && !empty($_POST['token'])) {

		$userId = $mysqli->real_escape_string($_POST['userId']); 
		$auth = $mysqli->real_escape_string($_POST['auth']);
		$token = $mysqli->real_escape_string($_POST['token']);

		if (userExistIdToken($userId, $token)) {

			if($userId > 0 && $auth > 0 ) {
			
				deleteUser($userId, $token);
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/users.php">';
				die();
			} else {

				$errors[] = "User doesn't exist";
			}


		} else {

			$errors[] = "User Doesn't exist";
		}
	}  else {

		$errors[] = "User Doesn't exist";
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
	<title>Delete User</title>
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
		<p class="title-login"><i class="fas fa-user-times"></i>Do you want delete this user?</p>
		<p><small><?php echo $email; ?></small></p>
		<input type="hidden" name="userId" id="userId" required value="<?php echo $id ?>">
		<input type="hidden" name="auth" id="auth" required value="<?php echo $auth ?>">
		<input type="hidden" name="token" id="token" required value="<?php echo $token ?>">
		<input type="submit" value="Delete" id="Delete">
		<?php  echo blockErrors($errors); ?>	
	</form>	

	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>
</body><body>
	
</body>
</html>