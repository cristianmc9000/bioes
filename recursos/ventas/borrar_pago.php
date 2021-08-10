<?php 
require("../conexion.php");
$id=$_GET["id"];
$codv = $_GET['codv'];
$result = $conexion->query("UPDATE pagos SET estado = 0 WHERE id = ".$id);
//debe comparar el saldo y el total y actualizar el estado de credito a 1 o 2 
$conexion->query("UPDATE ventas SET credito = 1 WHERE codv = ".$codv);

echo $result;

?>