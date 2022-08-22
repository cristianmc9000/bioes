<?php

require('../conexion.php');


if(isset($_GET["term"])) {

    $result = $conexion->query("SELECT * FROM clientes WHERE estado = 1 AND nivel = 'lider' AND CONCAT(CA,' ',nombre,' ',apellidos) LIKE '%".$_GET["term"]."%' ORDER BY CA ASC");
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
       $temp_array['label'] = $row['nombre'].' '.$row['apellidos'];

       $temp_array['nivel'] = $row['nivel'];
       
       $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

    // die($conexion->error);

 echo json_encode($output);
}

?>