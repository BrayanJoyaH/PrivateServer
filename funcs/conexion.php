<?php  


$mysqli = new mysqli(HOST, DBUSER, DBPASSWORD, DBNAME);

if($mysqli->connect_errno) {

    die('Error al conectarse a la base de datos '.$mysqli->connect_errno);
    
} 


?>