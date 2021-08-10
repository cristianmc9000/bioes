<?php 
require("../conexion.php");
$codli=$_GET["codli"];
$nombre=$_GET["nombre"];

$result = $conexion->query("UPDATE lineas SET nombre = '".$nombre."' WHERE codli = ".$codli);

echo $result;


?>