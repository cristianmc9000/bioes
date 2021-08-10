<?php
//Conectamos a la base de datos
require('../conexion.php');
require('../sesiones.php');
session_start();

$id = $_POST["id"];
$pupesos = $_POST["pupesos"];
$pubs = $_POST["pubs"];
$cantidad = $_POST["cantidad"];
$fecha_v = $_POST["fechav"];
$cant_ant = $_POST["cant_ant"];
if($fecha_v == ""){
	$fecha_v = '0000-00-00';
}

$cant = $cantidad - $cant_ant;

// $year = $_SESSION['anio'];

	//consulta modificar inventario 
	$consulta ="UPDATE inventario SET pupesos='".$pupesos."', pubs='".$pubs."', cantidad='".$cantidad."', fecha_venc='".$fecha_v."' WHERE id= '".$id."' ";
	mysqli_query($conexion, $consulta) or die(mysql_error()); 
		
	//consulta actualizar cantidad de inventario sumando o restando la cantidad ingresada (no es seguro)
	// $sql = "UPDATE `invcant` SET cantidad = cantidad + (".$cant.") WHERE codp = (SELECT codp FROM inventario WHERE id = ".$id.") ";
	// 	if (mysqli_query($conexion, $sql) or die(mysql_error())) {
	// 		die('?mes='.$periodo);
	// 	}else{
	// 		die(mysql_error());
	// 	}



//PARA ACTUALIZAR A LAS CANTIDADES CORRECTAS SUMANDO CANTIDADES DESDE INVENTARIO
 // $consulta = "SELECT id FROM productos WHERE estado = 1";
 // $busq = $conexion->query($consulta);

 // while ($arr = $busq->fetch_array()) {
 // 	//$sql = "UPDATE `invcant` SET cantidad = (SELECT SUM(b.cantidad) FROM inventario b WHERE b.codp = '".$arr['id']."') WHERE codp = '".$arr['id']."'";
 // 	$sql = "UPDATE invcant a SET a.cantidad = (SELECT IF((SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr['id']."')>0, (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = '".$arr['id']."'),0)) WHERE a.codp = '".$arr['id']."'";
 // 	$res = $conexion->query($sql);
 // }

$res = $conexion->query("UPDATE invcant a SET a.cantidad = (SELECT SUM(b.cantidad) FROM inventario b WHERE b.estado = 1 AND b.codp = (SELECT c.codp FROM inventario c WHERE c.id = ".$id.")) WHERE a.codp = (SELECT d.codp FROM inventario d WHERE d.id = ".$id.")");

$per = $_SESSION["periodo"];

if ($res && ( $per> 0 && $per <7 )) {
	die('?mes='.$per);
}else{
	die('');
}

?>


