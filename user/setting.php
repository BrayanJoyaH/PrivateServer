<?php  
session_start();

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';

if (!validateSession()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

} 

if (validatePublic()) {
	
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();
}

$errorsSend = array();
$errorsCreate = array();
$errorsEdit = array();
$errorsChange = array();

$userPublic = "";
$msgCreate = "";
$msgEdit = "";
$msgChange = "";
$email = $_SESSION['email'];
$name = $_SESSION['name'];
$user = $_SESSION['user'];


if (isset($_POST['Send'])) {

	if ($_FILES) {
		
		$newImage = $_FILES;

		$errorsSend[] = changeImageUser($newImage);
	}
	
}

if (isset($_POST['Create'])) {

	if (isset($_POST['PublicUser']) && isset($_POST['PublicPassword']) && isset($_POST['ConfirmPublicPassword']) && !empty($_POST['PublicUser']) && !empty($_POST['PublicPassword']) && !empty($_POST['ConfirmPublicPassword'])) {

		$userPublic = $mysqli->real_escape_string($_POST['PublicUser']);
		$Password = $mysqli->real_escape_string($_POST['PublicPassword']);
		$ConfirmPass = $mysqli->real_escape_string($_POST['ConfirmPublicPassword']);
		
		if (userExist($userPublic)) {
			
			$errorsCreate[] = "The user entered already exists";

		}

		if (!validatePassword($Password, $ConfirmPass)) {

			$errorsCreate[] = "Passwords do not match";
		}

		if (count($errorsCreate) == 0) {

			$pass_hash = hashPassword($Password);
			$token = generateToken();
			$type_user = 3;

			$registro = registerUser($userPublic, $pass_hash, $userPublic, 'public', 1, $token, $type_user);

			if ($registro > 0) {
				$msgCreate = '<p style="color: #4e9">User create</p>';
			} else {

				$errorsCreate[] = "Error";
			}
			

		} 

	} else {

		$errorsCreate[] = "You must fill all the inputs";
	}
	

}

if (isset($_POST['Edit'])) {

	if (isset($_POST['user']) && isset($_POST['name']) && isset($_POST['email']) && !empty($_POST['user']) && !empty($_POST['name']) && !empty($_POST['email'])) {

		$newUser = $mysqli->real_escape_string($_POST['user']);
		$newName = $mysqli->real_escape_string($_POST['name']);
		$newEmail = $mysqli->real_escape_string($_POST['email']);

		if (userExist($newUser) && $newUser != $_SESSION['user']) {
			
			$errorsEdit[] = "The user entered already exists";

		}

		if (emailExist($email) && $newEmail != $_SESSION['email']) {

			$errorsEdit[] = "The email entered already exists";
		}

		if (!isEmail($newEmail)) {
			
			$errorsEdit[] = "Invalid Email";
		}

		if (count($errorsEdit) == 0) {

			if (settingUser($newUser, $newName, $newEmail)) {
				$msgEdit = '<p style="color: #4e9">Info edited</p>';
			} else {

				$errorsEdit[] = "Error";
			}

		}



	} else {

		$errorsEdit[] = "You must fill all the inputs";
	}
	

}

if (isset($_POST['Change'])) {

	if (isset($_POST['password']) && isset($_POST['confirmPassword']) &&!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {

		$newPassword = $mysqli->real_escape_string($_POST['password']);
		$confirmNewPassword = $mysqli->real_escape_string($_POST['confirmPassword']);

		if (!validatePassword($newPassword, $confirmNewPassword)) {

			$errorsChange[] = "Passwords do not match";
		}

		if (count($errorsChange) == 0) {

			$pass_hash = hashPassword($newPassword); 
			
			if (editPassword($pass_hash)) {
				$msgChange = '<p style="color: #4e9">Password edited</p>';
			} else {

				$errorsChange[] = "Error";
			}
		}

	} else {

		$errorsChange[] = "You must fill all the inputs";
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
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/elements.css">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/scrollbar.css">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/setting.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title>Settings</title>
</head>
<body >

	<input type="checkbox" name="btnnavbar" id="btnnavbar">

	<aside class="navbar">
		
		<nav>
			<ul>
				<?php if ($_SESSION['id_tipo'] == 3) { ?>
					<li><a href="<?php echo SERVERURL; ?>home.php"><i class="far fa-file"></i><span>My files</span></a></li>
					<li><a href="<?php echo SERVERURL; ?>exit.php"><i class="fas fa-sign-out-alt"></i><span>Exit</span></a></li>
				<?php } ?>

				<?php if ($_SESSION['id_tipo'] == 1 || $_SESSION['id_tipo'] == 2) { ?>

				<li><a href="<?php echo SERVERURL; ?>home.php"><i class="far fa-file"></i><span>My files</span></a></li>
				<li><a href="<?php echo SERVERURL; ?>user/account.php"><i class="far fa-user"></i><span>Account</span></a></li>
				<?php if ($_SESSION['id_tipo'] == 1) { ?>
				<li><a href="<?php echo SERVERURL; ?>register.php"><i class="fas fa-user-plus"></i><span>Register User</span></a></li>
				<li><a href="<?php echo SERVERURL; ?>user/users.php"><i class="fas fa-users"></i><span>Users</span></a></li>

				<?php } ?>
				<li class="settings"><a href="<?php echo SERVERURL; ?>user/setting.php"  class="navActive"><i class="fas fa-cog"></i><span>Settings</span></a></li>
				<li><a href="<?php echo SERVERURL; ?>exit.php"><i class="fas fa-sign-out-alt"></i><span>Exit</span></a></li>

				<?php } ?>

			</ul>
		</nav>
	</aside>

	<input type="checkbox" name="btnuserImage" id="btnuserImage">
	
	<section class="header">
		<header><label for="btnnavbar"><i class="fas fa-bars"></i></label><span>&nbsp;Private <strong>Server<i class="fas fa-lock"></i></strong></span></header>
		
		<div class="userImage">
			<label for="btnuserImage" id="labeluserImage">
				<?php echo subUser($_SESSION['name']) ; ?>
			</label>
			<img src="<?php echo SERVERURL.$_SESSION['image']?>">
			<div class="userImage-options">
				<p><a href="<?php echo SERVERURL; ?>user/account.php"><span><?php echo $_SESSION['email']; ?></span><i class="fas fa-envelope"></i></a></p>
				<p><a href="<?php echo SERVERURL; ?>user/setting.php"><span>Settings</span><i class="fas fa-cog"></i></a></p>
				<p><a href="<?php echo SERVERURL; ?>exit.php"><span>Exit</span><i class="fas fa-sign-out-alt"></i></a></p>
			</div>
		</div>
	</section>

	<section class="files">
		<div class="info-container">
			<div class="imageUser">

				<img src="<?php echo SERVERURL.$_SESSION['image']?>">	
			</div>

			<div>
				<form  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="Send">
					<p class="title-login"><i class="fas fa-user"></i>Change Image</p>
					<input type="file" name="file" id="file" onchange="cambiar()" required>
					<label for="file" id="info">Select Image</label><br>
					<input type="submit" value="Send" name="Send" id="Send">
					<?php echo blockErrors($errorsSend);  ?>
				</form>

				<form  method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>#Create" id="Create">
					<p class="title-login"><i class="fas fa-user"></i>Create Public User</p>
					<input type="text" name="PublicUser" id="PublicUser" required autocomplete="off" placeholder="User" value="<?php echo $userPublic?>">
					<input type="password" name="PublicPassword" id="PublicPassword" required autocomplete="off" placeholder="Password" >
					<input type="password" name="ConfirmPublicPassword" id="ConfirmPublicPassword" required autocomplete="off" placeholder="Confirm Password" >
					<input type="submit" value="Create" name="Create" id="Create">
					<?php echo blockErrors($errorsCreate);  ?>
					<?php echo $msgCreate;  ?>
					
				</form>

				<form  method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>#Edit" id="Edit">
					<p class="title-login"><i class="fas fa-user"></i>Edit Account</p>
					<input type="text" name="name" id="name" required autocomplete="off" placeholder="Name" value="<?php echo $name ?>">
					<input type="text" name="user" id="user" required autocomplete="off" placeholder="Username" value="<?php echo $user ?>">
					<input type="email" name="email" id="email" required autocomplete="off" placeholder="Email" value="<?php echo $email ?>">
					<input type="submit" value="Edit" name="Edit" id="Edit">
					<?php echo blockErrors($errorsEdit);  ?>
					<?php echo $msgEdit;  ?>
				</form>
			
				<form  method="post" action="<?php echo $_SERVER['PHP_SELF']?>#Change" id="Change">
					<p class="title-login"><i class="fas fa-user"></i>Change Password</p>
					<input type="password" name="password" id="password" required autocomplete="off" placeholder="Password">
					<input type="password" name="confirmPassword" id="confirmPassword" required autocomplete="off" placeholder="Confirm Password">
					<input type="submit" value="Change" name="Change" id="Change">	
					<?php echo blockErrors($errorsChange);  ?>
					<?php echo $msgChange;  ?>
				</form>	
			</div>
		</div>
	</section> 
	
	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>

</body>
</html>