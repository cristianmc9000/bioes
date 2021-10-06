<?php 
	require("../conexion.php");
	require('../sesiones.php');
	// session_start();
	// $periodo = $_SESSION["periodo"];
	// $periodo = $_GET["periodo"];
	$result = $conexion->query("SELECT * FROM lineas WHERE estado = 1");
	while($row = $result->fetch_array(MYSQLI_ASSOC)) {
   		$rows[] = $row;
	}

	if (isset($rows)) {
		echo json_encode($rows);
	}else{
		echo '[{"codli":"","nombre":"","estado":""}]';
	}
	
?>