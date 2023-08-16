<?php  
session_start();

require '../config/config.php';
require '../funcs/conexion.php';
require '../funcs/funcs.php';

if (!validateSessionAdmin()) {

	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();

}


$users = getUsers();



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
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/users.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title><?php echo TITLEHOME ?></title>
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
				<li><a href="<?php echo SERVERURL; ?>user/users.php"  class="navActive"><i class="fas fa-users"></i><span>Users</span></a></li>

				<?php } ?>
				<li class="settings"><a href="<?php echo SERVERURL; ?>user/setting.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
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

		<?php foreach ($users as $user ) {?>
			<div class="UserInfo">
				<div class="user">
					<details>
						<summary>
							<?php echo subUser($user['nombre'])?>
							<span>
								<a href="<?php echo SERVERURL; ?>user/delete.php?id=<?php echo $user['id']?>&token=<?php echo $user['token']?>"><i class="far fa-trash-alt"></i></a>
								<a href="<?php echo SERVERURL; ?>user/edit.php?id=<?php echo $user['id']?>&token=<?php echo $user['token']?>"><i class="far fa-edit"></i></a>
							</span>
						</summary>
						<p>Name:&nbsp;&nbsp; <?php echo subUser($user['nombre']) ?> </p>
						<p>User:&nbsp;&nbsp; <?php echo subUser($user['usuario']) ?></p>
						<p>Email:&nbsp;&nbsp; <?php echo subEmail($user['correo']) ?></p>
						<p>TypeUser:&nbsp;&nbsp; <?php if ($user['id_tipo'] == 1) {
															$TypeUser = 'Admin';				
														} else if($user['id_tipo'] == 2) {
															$TypeUser = 'User';
														} elseif ($user['id_tipo']) {
															$TypeUser = 'Public';
														}
														echo $TypeUser;
												?></p>
						<p>Activate:&nbsp;&nbsp; <?php if ($user['activacion'] == 1) {
															$activate = 'Active';				
														} else {
															$activate = 'Inactive';
														}
														echo $activate;
												?></p>
					</details>
				</div>
			</div>
		<?php } ?>
	</section> 
	
	<footer>
		<a href="<?php echo MYWEB ?>" target="_BLANK">
			<i>Brayan Joya</i>&nbsp;&copy;
		</a>
	</footer>

</body>
</html>