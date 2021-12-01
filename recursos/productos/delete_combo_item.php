<?php 
require("../conexion.php");

$id_combo = $_GET['id_combo'];
$id_prod = $_GET['id_prod'];

$result = $conexion->query("DELETE FROM `combo` WHERE id_combo = '".$id_combo."' AND id_prod =  '".$id_prod."'");

if ($result) {
	echo '1';
}else{
	echo mysqli_error($conexion);
}

?>