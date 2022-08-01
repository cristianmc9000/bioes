<?php 
	session_start();
	require('../conexion.php');
	$dir = $_GET['dir'];
	$pass = $_GET['password'];
	$telf = $_GET['telf'];
	$ca = $_SESSION['ca'];
	$result = $conexion->query("UPDATE `clientes` SET `password`='".$pass."',`telefono`='".$telf."',`lugar`='".$dir."' WHERE CA = '".$ca."'");

	if ($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}
?>