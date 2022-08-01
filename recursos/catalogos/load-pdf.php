<?php 
require("../conexion.php");
//MOVER ESTE ARCHIVO A ARBELL

$nombreimg = $_FILES['pdf']['name'];
$archivo = $_FILES['pdf']['tmp_name'];


if(!empty($archivo)){

	$formatos_permitidos =  array('pdf');
	$extension = pathinfo($nombreimg, PATHINFO_EXTENSION);
	if(!in_array($extension, $formatos_permitidos) ) {
	    die("3");
	}

	//$ruta = $_SERVER['DOCUMENT_ROOT']."/images/fotos_prod"; //PARA SUBIR A 000WEBHOST
	$ruta = $_SERVER['DOCUMENT_ROOT']."/pedidos/images/pdf";
	$ruta = $ruta."/".$nombreimg;
	move_uploaded_file($archivo, $ruta);
	$ruta2 = "images/pdf/".$nombreimg;
}else{
	// $ruta2 = "images/fotos_prod/defecto.png";
	die("2");
} 

$result = $conexion->query("INSERT INTO catalogos (codigo,ruta) VALUES ('Catálogo Verano 2022', '".$ruta2."')");

die($result);

?>
