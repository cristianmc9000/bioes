<?php
//fetch_data.php

include('../conexion.php');


if(isset($_GET["term"]))
{


    $result = $conexion->query("SELECT a.id, a.combo, (SELECT f.descuento FROM detalle_compra f WHERE f.codp = a.id ORDER BY f.codc DESC LIMIT 1) AS descuento,(SELECT d.pupesos FROM inventario d WHERE d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY d.id DESC LIMIT 1) AS maxpupesos, c.cantidad AS stock, a.linea, a.descripcion, a.foto, b.nombre FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY a.id ASC");

    //modificar consulta para que salga nombre de la linea ...
    // $result = $conexion->query("SELECT a.id, a.periodo, (SELECT d.pupesos FROM inventario d WHERE d.fecha_reg = (SELECT MAX(e.fecha_reg) FROM inventario e WHERE e.codp = a.id) AND d.codp = a.id AND CONCAT(d.codp,' ',a.descripcion) LIKE '%".$_GET["term"]."%' LIMIT 1) AS maxpupesos,c.cantidad AS stock, a.linea, a.descripcion, a.foto, b.nombre FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.linea = b.codli AND CONCAT(a.id,' ',a.descripcion) LIKE '%".$_GET["term"]."%' ORDER BY a.id ASC");<-- consulta anterior

    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
        $temp_array = array();
        $temp_array['id'] = $row['id'];
        $temp_array['descuento'] = $row['descuento'];
        $temp_array['stock'] = $row['stock'];
        $temp_array['linea'] = $row['nombre'];
        $temp_array['codli'] = $row['linea'];
        $temp_array['value'] = $row['descripcion'];
        $temp_array['combo'] = $row['combo'];

        $temp_array['menor'] = "";
        if($row['combo'] == '1'){
          $res = $conexion->query("SELECT MIN(b.cantidad) as cantidad FROM combo a, invcant b WHERE id_combo = '".$row['id']."' AND b.codp = a.id_prod ");
          $res = $res->fetch_all(MYSQLI_ASSOC);
          $temp_array['menor'] = json_encode($res);
        }

        $temp_array['label'] = '<img class="zoom" src="'.$row['foto'].'" width="85" />   '.$row['descripcion'].'';
        $temp_array['pupesos'] = $row['maxpupesos'];
        $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}
?>

