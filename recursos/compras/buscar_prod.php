<?php
include('../conexion.php');

if(isset($_GET["term"]))
{

    $result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, (SELECT f.descuento FROM detalle_compra f WHERE f.codp = a.id ORDER BY f.codc DESC LIMIT 1) AS descuento, (SELECT d.pupesos FROM inventario d WHERE d.fecha_reg = (SELECT MAX(e.fecha_reg) FROM inventario e WHERE e.codp = a.id) AND d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' LIMIT 1) AS pupesos, b.nombre FROM productos a, lineas b WHERE a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY id ASC;");

    // $result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, (SELECT f.descuento FROM detalle_compra f WHERE f.codp = a.id ORDER BY a.id DESC LIMIT 1) AS descuento, (SELECT d.pupesos FROM inventario d WHERE d.fecha_reg = (SELECT MAX(e.fecha_reg) FROM inventario e WHERE e.codp = a.id) AND d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' LIMIT 1) AS pupesos, b.nombre FROM productos a, lineas b WHERE a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY id ASC;"); <--- consulta

    // $result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, (SELECT f.descuento FROM detalle_compra f WHERE f.codp = a.id AND f.codc = (SELECT MAX(f.codc) FROM detalle_compra) ORDER BY a.id DESC LIMIT 1) AS descuento, (SELECT d.pupesos FROM inventario d WHERE d.fecha_reg = (SELECT MAX(e.fecha_reg) FROM inventario e WHERE e.codp = a.id) AND d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' LIMIT 1) AS pupesos, b.nombre FROM productos a, lineas b WHERE a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY id ASC"); <---ANTERIOR CONSULTA

    // $result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, (SELECT d.pupesos FROM inventario d WHERE d.fecha_reg = (SELECT MAX(e.fecha_reg) FROM inventario e WHERE e.codp = a.id) AND d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' LIMIT 1) AS pupesos, b.nombre FROM productos a, lineas b WHERE a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY id ASC");

    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
       $temp_array = array();
       $temp_array['id'] = $row['id'];
       $temp_array['linea'] = $row['nombre'];
       $temp_array['codli'] = $row['linea'];
       $temp_array['value'] = $row['descripcion'];
       $temp_array['label'] = '<img class="zoom" src="'.$row['foto'].'" width="85" />   '.$row['descripcion'].'';
       $temp_array['pupesos'] = $row['pupesos'];
       $temp_array['descuento'] = $row['descuento'];

       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}

?>