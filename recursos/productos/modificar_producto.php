<?php
//Conectamos a la base de datos
require('../conexion.php');
define ('SITE_ROOT', realpath(dirname(__FILE__)));

$cod = $_POST["codigo"];
$codant = $_POST["codant"];
$linea = $_POST["linea"];
$descripcion = $_POST["descripcion"];
$pubs = $_POST["precio_bs"];
// $periodo = $_SESSION["periodo"];
$imgant = $_POST['imagen_ant'];
$nombreimg = $_FILES['imagen']['name'];
$archivo = $_FILES['imagen']['tmp_name'];
$maxCaracteres = "250";
// die($imgant." <-----");

$check_promo = $_POST['check_promo'];
$check_pedido = $_POST['check_pedido'];


if (empty($check_promo) AND empty($check_pedido)) {
	$result = $conexion->query("UPDATE `productos` SET `checkbox`='0' WHERE id = '".$codant."'");
}
if ($check_promo == 'on') {
	$result = $conexion->query("UPDATE `productos` SET `checkbox`='1' WHERE id = '".$codant."'");
}
if ($check_pedido == 'on') {
	$result = $conexion->query("UPDATE `productos` SET `checkbox`='2' WHERE id = '".$codant."'");
}


if (!empty($pubs)) {
	$cambio = $_POST['_cambio'];
	$pup = ((float)$pubs) / ((float)$cambio);
	$pup = round($pup, 1);
	$result = $conexion->query("UPDATE inventario a SET a.pupesos='".$pup."',a.pubs='".$pubs."' WHERE a.codp = '".$codant."' AND id = (SELECT MAX(b.id) FROM inventario b WHERE a.codp = b.codp AND b.estado = 1)");
	if (!$result) {
		die(mysqli_error($conexion));
	}
}



if(strlen($descripcion) > $maxCaracteres) {
	die('<script>mtoast("La descripción del producto no puede superar los 250 caracteres." , "warning");</script>');
};

/* FALTA AGREGAR BIEN LA RUTA DE LAS IMAGENES */
if(!empty($archivo)){
	$ruta = $_SERVER['DOCUMENT_ROOT']."/images/fotos_prod"; //PARA SUBIR AL 000WEBHOST
	// $ruta = $_SERVER['DOCUMENT_ROOT']."/bioes/images/fotos_prod"; //imagenes local
	$ruta = $ruta."/".$nombreimg;
	move_uploaded_file($archivo, $ruta);
	$ruta2 = "images/fotos_prod/".$nombreimg;
}else{
	$ruta2 = $imgant;
}

if ($cod != $codant) {
	$consultaBuscarID = "SELECT * FROM productos WHERE id = '".$cod."'";
	$resultadoConsultaBID = mysqli_query($conexion, $consultaBuscarID) or die(mysqli_error($conexion));
	$datosConsultaBID = mysqli_fetch_array($resultadoConsultaBID);

	if(isset($datosConsultaBID['id'])){
		die('<script>mtoast("Ya existe un producto con el código: '.$cod.'" , "warning")</script>');

	}
}


	$consulta ="UPDATE productos SET id='".$cod."', foto='".$ruta2."', linea='".$linea."', descripcion='".$descripcion."' WHERE id= '".$codant."'";

	if(mysqli_query($conexion, $consulta) or die(mysqli_error($conexion))) {
		die('1');
	}

?>