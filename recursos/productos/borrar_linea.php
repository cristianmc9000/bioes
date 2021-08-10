<?php 

require("../conexion.php");
$id=$_GET["id"];

$sql = $conexion->query("SELECT id FROM productos WHERE estado = 1 AND linea = ".$id);
if(mysqli_num_rows($sql) == 0){
	$result = $conexion->query("UPDATE lineas SET estado = 0 WHERE codli = ".$id);
	echo true;
}else{
	echo false;
}



?>
