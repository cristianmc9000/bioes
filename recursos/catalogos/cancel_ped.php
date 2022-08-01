<?php 
require('../conexion.php');

$id = $_GET['cod'];


// $consulta = "DELETE FROM pedidos WHERE id = ".$id;
// $consulta2 = "DELETE FROM detalle_pedido WHERE  codped = ".$id;
// mysqli_query($conexion, $consulta2) or die(mysqli_error($conexion));
// mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

$result = $conexion->query("DELETE FROM detalle_pedido WHERE  codped = ".$id);
$result2 = $conexion->query("DELETE FROM pedidos WHERE id = ".$id);

die($result.$result2);

?>