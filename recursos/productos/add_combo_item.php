<?php 
	require("../conexion.php");

	$id_combo = $_GET['id_combo'];
	$id_prod = $_GET['id_prod'];

	$result = $conexion->query("INSERT INTO `combo`(`id_combo`, `id_prod`) VALUES ('".$id_combo."', '".$id_prod."')");

	if ($result) {
		echo "1";
	}else{
		echo mysqli_error($conexion);
	}

?>