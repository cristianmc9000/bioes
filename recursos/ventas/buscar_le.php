<?php
//fetch_data.php

include('../conexion.php');



if(isset($_GET["term"]))
{
    //modificar consulta para que salga nombre de la linea ...
    $result = $conexion->query("SELECT CA, CI, nombre, apellidos, telefono, lugar, correo, nivel FROM clientes WHERE estado = 1 AND CONCAT(CA,' ',nombre,' ',apellidos) LIKE '%".$_GET["term"]."%' ORDER BY CA ASC");
    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
       $temp_array = array();
       $temp_array['ca'] = $row['CA'];
       $temp_array['lugar'] = $row['lugar'];
       /* $temp_array['nombre'] = $row['nombre']; */
       $temp_array['value'] = $row['nombre'].' '.$row['apellidos'];
       $temp_array['label'] = $row['CA'].' '.$row['nombre'].' '.$row['apellidos'];

       $temp_array['nivel'] = $row['nivel'];
       
       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}

?>