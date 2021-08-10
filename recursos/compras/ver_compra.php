<?php
require("../conexion.php"); 
$codc=$_GET["codc"];
$result= $conexion->query("SELECT a.codc, b.codp, b.cantidad, c.descripcion, b.pubs, b.pubs_cd, b.pupesos_cd, c.linea as codli, (SELECT d.nombre FROM lineas d WHERE c.linea = d.codli) as linea FROM compras a, detalle_compra b, productos c WHERE b.codc = a.codc  AND b.estado = 1 AND b.codp = c.id AND a.codc = ".$codc);

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}

// echo $rows[0]['codv']; //reading a single element of array
echo json_encode($rows);


?>