<?php 
require("../conexion.php");
$codc = $_GET['codc'];
$descuento = $_GET['descuento'];

$descuento = 100 - (int)$descuento;
$descuento = $descuento * 0.01;

$result = $conexion->query("UPDATE detalle_compra SET pupesos_cd = pupesos*".$descuento.", pubs_cd = pubs*".$descuento." WHERE codc = ".$codc);
$res = $conexion->query("UPDATE compras SET descuento = ".$_GET['descuento'].", totalcd = (SELECT SUM(b.pubs_cd*b.cantidad) FROM detalle_compra b WHERE b.codc = ".$codc.") WHERE codc = ".$codc);


return $res;
?>