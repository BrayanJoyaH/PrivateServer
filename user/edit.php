<?php 
session_start();

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';

if (!validateSessionAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 


$errors = array();
$typeUser = "";
$Activate = "";
$email = "";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['token']) && !empty($_GET['token'])) {

	$id = $mysqli->real_escape_string($_GET['id']);
	$token = $mysqli->real_escape_string($_GET['token']);

	if (userExistIdToken($id, $token)) {
		$email = getInfo('correo', 'usuarios', 'id', $id);
		$typeUser = getInfo('id_tipo', 'usuarios', 'id', $id);
		$typeUser = $typeUser == 1 ? "Admin" : "User";
		$Activate = getInfo('activacion', 'usuarios', 'id', $id);
		$Activate = $Activate == 1 ? "Active" : "Desactive";
	} else {
		$errors[] = "User doesn't exist";
	}
 
} else {

	if(isset($_POST['userId']) && !empty($_POST['userId']) && isset($_POST['token']) && !empty($_POST['token']) && isset($_POST['Activate']) && !empty($_POST['Activate']) && isset($_POST['typeUser']) && !empty($_POST['typeUser'])) {

	
		$userId = $mysqli->real_escape_string($_POST['userId']); 
		$Activate = $mysqli->real_escape_string($_POST['Activate']);
		$token = $mysqli->real_escape_string($_POST['token']);
		$typeUser = $mysqli->real_escape_string($_POST['typeUser']);

		if (userExistIdToken($userId, $token)) {

			$typeUser = $typeUser == "Admin" ? 1 : 2;
			$Activate = $Activate == "Active" ? 1 : 0;

			if (editUser($userId, $token, $typeUser, $Activate)) {

				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'user/users.php">';
				die();
				

			} else {

				$errors[] = "Error to update the info";
			}


		} else {

			$errors[] = "User Doesn't exist";
		}
	}  else {

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
	<title>Edit user</title>
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
		<p class="title-login"><i class="fas fa-edit"></i>Edit User</p>
		<p><small><?php echo $email; ?></small></p>
		<input type="hidden" name="userId" id="userId" required value="<?php echo $id ?>">
		<input type="hidden" name="token" id="token" required value="<?php echo $token ?>">
		<select name="typeUser" >
			<option value="<?php echo $typeUser?>"><?php echo $typeUser?></option>
			<?php if ($typeUser == "Admin"){ ?>
				<option value="User">User</option>
				
			<?php } else { ?>

				<option value="Admin">Admin</option>
			<?php }?>

		</select>
		<select name="Activate" >
			<option value="<?php echo $Activate?>"><?php echo $Activate?></option>
			<?php if ($Activate == "Active"){ ?>
				<option value="Desactive">Desactive</option>
				
			<?php } else { ?>

				<option value="Active">Active</option>
			<?php }?>

		</select>
		
		<input type="submit" value="Edit" id="Edit">	
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