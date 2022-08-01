<?php 
require("../conexion.php");

$res = $conexion->query("SELECT * FROM catalogos ORDER BY id DESC LIMIT 1");

$res = $res->fetch_assoc();

echo json_encode($res);

?>