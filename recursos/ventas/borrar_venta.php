<?php 
require("../conexion.php");
$codv=$_GET["codv"];

$conexion->query("UPDATE ventas SET estado = 0 WHERE codv = ".$codv);

//PARA DEVOLVER LAS CANTIDADES AL INVENTARIO
$result = $conexion->query("SELECT codp, cantidad FROM detalle_venta WHERE estado=1 AND codv = ".$codv);
while($arr = $result->fetch_array()){
    $conexion->query("UPDATE inventario a SET a.estado=1, a.cantidad = a.cantidad + ".$arr['cantidad']." WHERE a.codp = '".$arr['codp']."' AND a.id = (SELECT MAX(id) FROM (SELECT * FROM inventario WHERE codp = '".$arr['codp']."') AS maxid )");

    //Para actualizar las cantidades correctas de invcant
	$r = $conexion->query("UPDATE invcant a SET a.cantidad = (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr['codp']."') WHERE a.codp = '".$arr['codp']."'");

}
//Consulta para poner el detalle de venta en estado = 0
$conexion->query("UPDATE detalle_venta SET estado = 0 WHERE codv = ".$codv);



echo $r;

?>