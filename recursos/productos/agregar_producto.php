<?php
require('../conexion.php');
require('../sesiones.php');
session_start();
define ('SITE_ROOT', realpath(dirname(__FILE__)));
$cod = $_POST["codigo"];
$linea = $_POST["linea"];
$descripcion = $_POST["descripcion"];
// $pupesos = $_POST["pupesos"];
// $pubs = $_POST["pubs"];
// $cantidad = $_POST["cantidad"];
// $fechav = $_POST["fechav"];
// $periodo = $_SESSION["periodo"];
// $year = $_SESSION['anio'];
$nombreimg = $_FILES['imagen']['name'];
$archivo = $_FILES['imagen']['tmp_name'];
$maxCaracteres = "250";

$combo = 0;
$text = "";
$json_combo = $_POST['json_combo'];
if ($json_combo != "") {
	$json_combo = json_decode($json_combo);
	$combo = 1;
}else{
	$combo = 0;
}





if(!empty($archivo)){
	$ruta = $_SERVER['DOCUMENT_ROOT']."/images/fotos_prod"; //PARA SUBIR A 000WEBHOST
	// $ruta = $_SERVER['DOCUMENT_ROOT']."/bioes/images/fotos_prod"; //PARA USAR IMAGENES LOCALMENTE
	$ruta = $ruta."/".$nombreimg;
	move_uploaded_file($archivo, $ruta);
	$ruta2 = "images/fotos_prod/".$nombreimg;
}else{
	$ruta2 = "images/fotos_prod/defecto.png";
} 

/* die ($_SERVER['DOCUMENT_ROOT']); */


if(strlen($descripcion) > $maxCaracteres) {
	die('<script>mtoast("La descripción del producto no puede superar los 250 caracteres." , "warning");</script>');
};

	$consultaBuscarID = "SELECT * FROM productos WHERE id = '".$cod."'";
	$resultadoConsultaBID = mysqli_query($conexion, $consultaBuscarID) or die(mysqli_error($conexion));
	$datosConsultaBID = mysqli_fetch_array($resultadoConsultaBID);

	if(isset($datosConsultaBID['id'])){
		die('<script>mtoast("Ya existe un producto con el código: '.$cod.'" , "warning")</script>');
	}

	//Consulta para agregar el nuevo producto 
	$consulta = "INSERT INTO productos (id, foto, linea, descripcion, combo) VALUES ('".$cod."','".$ruta2."','".$linea."','".$descripcion."','".$combo."')";
	mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

	//Consulta para agregar detalle del producto combo
	if($combo == 1){
		foreach($json_combo as $arr ){
			$sql = "INSERT INTO `combo`(`id_combo`, `id_prod`) VALUES ('".$cod."','".$arr->{'id'}."')";
			$result = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));
		}
	}

	//Consulta para agregar la cantidad del nuevo producto
	$consultaAC = "INSERT INTO invcant (codp) VALUES('".$cod."')";
	if(mysqli_query($conexion, $consultaAC) or die(mysqli_error($conexion))) {
		die("1");
	}


?>