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

if (isset($_GET['cid']) && isset($_GET['type']) && !empty($_GET['cid']) && !empty($_GET['type'])) {
	
	$cid = $_GET['cid'];
	$type = $_GET['type'];
	$name = getInfo('name', 'files', 'cid', $cid);

} else {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();
}

if (!fileExist($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'document/404.php">';
	die();

}

if (!validateFileUser($cid)) {
	echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'index.php">';
	die();
}

?>

<!DOCTYPE html>
<html>
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
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/view.css">
	<link rel="stylesheet" href="<?php echo SERVERURL ?>css/scrollbar.css">
	<!--	ICONS fontawesome-free	-->
	<link rel="stylesheet" href="<?php echo SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
	<!--    SCRIPT JS    --->
	<script src="<?php echo SERVERURL ?>js/script.js"></script>
	<title><?php echo $name; ?></title>
</head>
<body>

	<?php if ($type == "jpg" || $type == "png" || $type == "jpeg" || $type == "gif"){ ?>

		<div class="super-container">
			<div class="containerImage">
				<div class="info">
					<a href="<?php echo SERVERURL;?>service/download.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>"><i class="fas fa-download" title="Download"></i></a>
					<img src="document.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>"></img>
				</div>
				
			</div>
		</div>
	<?php } elseif ($type == "css" || $type == "html" || $type == "js" || $type == "txt"){ ?>

		<div class="super-container">
			<div class="info-text">
				<a href="<?php echo SERVERURL;?>service/download.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>"><i class="fas fa-download" title="Download"></i></a>
				<iframe src="document.php?type=<?php echo $type ?>&cid=<?php echo $cid ?>" class="iframe-text"></iframe> 
					
			</div>
			
		</div>
		
	<?php } elseif ($type == "pdf"){ ?>

		<iframe src="document.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>" class="iframe-pdf"></iframe> 

	<?php } elseif ($type == "mp4" || $type == "ogg" || $type == "ogv"){  ?>

		<div class="super-container">
			<div class="containerImage">
				<div class="info">
					<a href="<?php echo SERVERURL;?>service/download.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>"><i class="fas fa-download" title="Download"></i></a>
					<video controls class="video">
						<source src="document.php?type=<?php echo $type ?>&cid=<?php echo $cid  ?>" type="video/mp4">
					</video> 
				</div>
				
			</div>
		</div>

	<?php } else { ?>

		<div class="super-container">
			
			<a href="<?php echo SERVERURL;?>service/download.php?type=<?php echo $type ?>&cid=<?php echo $cid ?>" class="dwl"><i class="fas fa-download">&nbsp;Donwload to watch</i></a>	
		</div>
	
	<?php } ?>
		
</body>
</html>

