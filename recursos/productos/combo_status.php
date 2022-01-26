<?php 
require("../conexion.php");

$id = $_GET['id'];
$status = $_GET['status'];
$result = $conexion->query("UPDATE `productos` SET `combo`= ".$status." WHERE id = '".$id."'");

if ($status == '0') {
	$conexion->query("DELETE FROM combo WHERE id_combo = '".$id."'");
}

if ($result) {
	echo $result;
}else{
	echo mysqli_error($conexion);
}

?>