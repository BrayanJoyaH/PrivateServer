<?php 

function subname($str) {

	if (strlen($str) > 10) {
		
		$str = substr($str, 0, 6)."...".substr($str, -1);
		
	} else {
		$str = $str;
	}
	return $str;
}

function getFiles($index) {

	global $mysqli;

	$rows = null;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("SELECT * FROM files WHERE id_user = ? AND token_user = ? AND fld = ?");
	$stmt->bind_param('iss', $_SESSION['id'], $token, $index);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($file = $result->fetch_assoc()) {
		
		$rows[] =  $file;
	}

	return $rows;
}

function getFolder($index) {

	global $mysqli;

	$rows = null;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("SELECT * FROM folders WHERE id_user = ? AND token_user = ? AND fld = ?");
	$stmt->bind_param('iss', $_SESSION['id'], $token, $index);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($file = $result->fetch_assoc()) {
		
		$rows[] =  $file;
	}

	return $rows;
}

function addFile($file, $index) {

	global $mysqli;

	$errors = null;
	$cid = generateToken();
	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);
	$targetDir = getAddressFolder('url', 'folders', 'cid' , $index);
	

	if(file_exists($targetDir)) {

		$targetFile = $targetDir."/" . basename($file['file']['name']);
		$name = basename($file['file']['name']);
		$uploadDk = 1;
		$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

		if ($file['file']['size'] > 3000000000000) {

			$errors = "The file is very big";
			$uploadDk = 0;
		}

		if (fileExist($file['file']['name'])) {

			$url = getInfo('url', 'files', 'name', $file['file']['name']);
			$link = "../".$targetFile;

			if( $url == $link) {
				$targetFile = $targetDir."/" . $cid.basename($file['file']['name']);
				$name = $cid.basename($file['file']['name']);
			}
			


		}

		if ($uploadDk == 0) {

			return $errors;

		} else {

			if (move_uploaded_file($file['file']['tmp_name'], $targetFile)) {
				
				$direction = "../".$targetFile;
				$stmt = $mysqli->prepare("INSERT INTO files (fld, url, name, state, extension, id_user, token_user, cid) VALUES (?, ?, ?, 'normal', ?, ?, ?, ?)");
				$stmt->bind_param('ssssiss', $index, $direction, $name, $imageFileType, $_SESSION['id'], $token, $cid);
				$stmt->execute();

				if ($index == "root") {
					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'home.php">';
				} else {
					echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'page.php?cid='.$index.'">';
				}

			} else {
				$errors = "Sorry, the image can't be upload, try again";
			}
		}

	} else {

		$errors = "The folder direction to save doesn't exists";
		
	}	

	return $errors;	
}

function createFolder($folderName, $index) {

	global $mysqli;

	$cid = generateToken();
	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);
	$targetDir = getAddressFolder('url', 'folders', 'cid' , $index);
	$targetDirCreate = $targetDir."/".$folderName;	


	if(file_exists($targetDir)) {

		if (folderExist($folderName)) {

			$url = getInfo('url', 'folders', 'name', $folderName);
			$link = $targetDirCreate;

			if( $url == $link) {
				$targetDirCreate = $targetDirCreate . $cid;
				$folderName = $folderName.$cid;
			}
	
		}

		if (mkdir($targetDirCreate)) {
				
			$stmt = $mysqli->prepare("INSERT INTO folders (fld, url, name, id_user, token_user, cid) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param('sssiss', $index, $targetDirCreate, $folderName, $_SESSION['id'], $token, $cid);
			$stmt->execute();

			if ($index == "root") {
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'home.php">';
			} else {
				echo '<meta http-equiv="refresh" content="0; url='.SERVERURL.'page.php?cid='.$index.'">';
			}

		} 
	} 	
}

function createFolderRegister($user, $token) {

	global $mysqli;

	$cid = "root";
	$targetDir = "files/private/$token/root";

	$link = "files/private/$token";
	mkdir($link);
	mkdir($targetDir);
	
	$stmt = $mysqli->prepare("INSERT INTO folders (fld, url, name, id_user, token_user, cid) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssiss', $cid, $targetDir, $cid, $user, $token, $cid);
	$stmt->execute();
}

function fileExist($cid) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("SELECT id FROM files WHERE cid = ? || name = ? AND id_user = ? AND token_user = ? LIMIT 1");

	$stmt->bind_param("ssis", $cid, $cid, $_SESSION['id'], $token);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	if($num > 0) {
		return true;
	} else {
		return false;
	}
}

function folderExist($cid) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("SELECT id FROM folders WHERE cid = ? || name = ? AND id_user = ? AND token_user = ? LIMIT 1");

	$stmt->bind_param("ssis", $cid, $cid, $_SESSION['id'], $token);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	if($num > 0) {
		return true;
	} else {
		return false;
	}
}

function validateFileUser($cid) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM files WHERE cid = ? AND id_user = ? LIMIT 1");

	$stmt->bind_param("si", $cid, $_SESSION['id']);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	if($num > 0) {
		return true;
	} else {
		return false;
	}
}

function validateFolderUser($cid) {

	global $mysqli;

	$stmt = $mysqli->prepare("SELECT id FROM folders WHERE cid = ? AND id_user = ? LIMIT 1");

	$stmt->bind_param("si", $cid, $_SESSION['id']);
	$stmt->execute();
	$stmt->store_result();
	$num = $stmt->num_rows;
	$stmt->close();

	if($num > 0) {
		return true;
	} else {
		return false;
	}
}

function deleteFoldersDB($cid) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id', $_SESSION['id']);

	$folders = getFolder($cid);
	$files = getFiles($cid);

	if ($files != null) {
		if (count($files) > 0) {
		
			deleteFilesDB($cid);
		}
	}

	if ($folders != null) {
		if (count($folders) > 0) {
		
			foreach ($folders as $folder) {
			
				deleteFoldersDB($folder['cid']);
			}
		}
	}

	
	$stmt = $mysqli->prepare("DELETE FROM folders WHERE fld = ? AND id_user = ? AND token_user = ?");
	$stmt->bind_param('sis', $cid, $_SESSION['id'], $token);
	$stmt->execute();
	
}

function deleteFilesDB($cid) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id', $_SESSION['id']);

	$stmt = $mysqli->prepare("DELETE FROM files WHERE fld = ? AND id_user = ? AND token_user = ?");
	$stmt->bind_param('sis', $cid, $_SESSION['id'], $token);
	$stmt->execute();

}

function deleteFile($cid, $type) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id', $_SESSION['id']);
	$target = getInfo('url', 'files', 'cid', $cid);

	if (file_exists($target)) {
		
		unlink($target);
	}

	$stmt = $mysqli->prepare("DELETE FROM files WHERE id_user = ? AND token_user = ? AND cid = ? AND extension = ? LIMIT 1");
	$stmt->bind_param('ssss', $_SESSION['id'], $token, $cid, $type);
	$stmt->execute();
	$stmt->close();
}

function deleteFolder($cid) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id', $_SESSION['id']);
	$target = "../".getInfo('url', 'folders', 'cid', $cid);

	if (file_exists($target)) {
		
		deleteDirectory($target);
	}

	$stmt = $mysqli->prepare("DELETE FROM folders WHERE id_user = ? AND token_user = ? AND cid = ? LIMIT 1");
	$stmt->bind_param('sss', $_SESSION['id'], $token, $cid);
	$stmt->execute();
	$stmt->close();

	deleteFoldersDB($cid);
}


function deleteAllUserFilesDB($id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("DELETE FROM files WHERE id_user = ? AND token_user = ?");
	$stmt->bind_param('is', $id, $token);
	$stmt->execute();
	$stmt->close();

	deleteAllUserFoldersDB($id, $token);


}

function deleteAllUserFoldersDB($id, $token) {

	global $mysqli;

	$stmt = $mysqli->prepare("DELETE FROM folders WHERE id_user = ? AND token_user = ?");
	$stmt->bind_param('is', $id, $token);
	$stmt->execute();
	$stmt->close();


}

function getAddressFolder($info, $table, $whereParam, $whereValue) {

	global $mysqli;

	$token = getInfo('token', 'usuarios', 'id' , $_SESSION['id']);

	$stmt = $mysqli->prepare("SELECT $info FROM $table WHERE $whereParam = ? AND id_user = ? AND token_user = ? LIMIT 1");
	$stmt->bind_param('sis', $whereValue, $_SESSION['id'], $token);
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	if ($rows > 0) {

		$stmt->bind_result($_info);
		$stmt->fetch();
		return $_info;		
	} else {
		return null;
	}
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

?>