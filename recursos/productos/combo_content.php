<?php 
require("../conexion.php");

$id = $_GET['id'];

// $result = $conexion->query("SELECT a.id_prod, (SELECT b.descripcion WHERE a.id_prod = b.id) as nompro FROM combo a, productos b WHERE a.id_combo = '".$id."' AND a.id_prod = b.id AND a.estado = 1");

$result = $conexion->query("SELECT a.id_prod, c.cantidad,(SELECT b.descripcion WHERE a.id_prod = b.id) as nompro FROM combo a, productos b, invcant c WHERE c.codp = b.id AND c.codp = a.id_prod AND a.id_combo = '".$id."' AND a.id_prod = b.id AND a.estado = 1");

$res = $result->fetch_all(MYSQLI_ASSOC); //PARA OBTENER EL ARRAY COMPLETO SIN HACER FOREACH O WHILE
echo json_encode($res);
// SELECT a.id_prod, (SELECT b.descripcion WHERE a.id_prod = b.id) FROM combo a, productos b WHERE a.id_combo = "222" AND a.id_prod = b.id AND a.estado = 1
?>

