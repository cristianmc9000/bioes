<?php 
	session_start();
	require("../conexion.php");
	$ca = $_SESSION['ca'];

	$result = $conexion->query("SELECT * FROM clientes WHERE lider = ".$ca." AND CONCAT(CA,' ',nombre,' ',apellidos) LIKE '%".$_GET["key"]."%'");
	if ($result) {
		$res = $result->fetch_all(MYSQLI_ASSOC);
		echo json_encode($res);
	}else{
		echo mysqli_error($conexion);
	}
	
?>