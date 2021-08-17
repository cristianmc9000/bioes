<?php 

<<<<<<< HEAD
$conexion = new mysqli('bvkp1uqpwrvsuioatujl-mysql.services.clever-cloud.com','umq5o56fqyxs8loy','2hxcnX6DzQoI2W8EgCPT','bvkp1uqpwrvsuioatujl');
//('localhost','u604223767_bio','papapapa1212AC!','u604223767_bio'); //BASE HOSTINGER.

=======
// $conexion = new mysqli('localhost','u604223767_bio','papapapa1212AC!','u604223767_bio'); //BASE HOSTINGER.
$conexion = new mysqli('localhost','root','','bio'); //base localhost
>>>>>>> 5cc380b3c2d2cd409865c8c56ab6bb90d508e8e0

//$conexion = new mysqli('br6vrwqejcpdav29tluj-mysql.services.clever-cloud.com','usz8khcb6vchmslt','1DjIm6ncGfmq6N81hRtt','br6vrwqejcpdav29tluj');

$conexion->query("SET NAMES 'utf8'");
if($conexion->connect_error) { 
	die( 'Error: ('. $conexion->connect_errno .' )'. $conexion->connect_error); 
}
?>