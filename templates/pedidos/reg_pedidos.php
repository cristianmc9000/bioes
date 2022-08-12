<?php

require('../../recursos/conexion.php');
date_default_timezone_set("America/La_Paz");
$year = date('Y');
if (isset($_GET["ges"])) {
  $year = $_GET["ges"];
}

$Sql = "SELECT a.id, a.ca, CONCAT(c.nombre,' ',c.apellidos) as cliente, a.fecha, a.total, a.total_cd, a.descuento, a.valor_peso, a.credito FROM pedidos a, clientes c WHERE a.ca = c.CA AND a.estado = 2 AND a.fecha LIKE '".$year."%'";


$Busq = $conexion->query($Sql); 
$fila = $Busq->fetch_all(MYSQLI_ASSOC);
?>

<style>
.fuente{
    color: red;
}
.fuente_azul{
    color: black;
}
</style>

<div class="row">
<div class="col-sm-11">
<div class="row">
    <div class=" col-sm-4 ">
        <div class="col-sm-4">
            <b style= "color:blue"> Gestión:</b>
            <select onchange="enviarfecha()" name="ges" id="ges" class="form-select">
                <option value="<?php echo $year ?>" selected disabled><?php echo $year?></option>
                <option value="2022"> 2022 </option>
                <option value="2023"> 2023 </option>
                <option value="2024"> 2024 </option>
                <option value="2025"> 2025 </option>
                <option value="2026"> 2026 </option>
                <option value="2027"> 2027 </option>
            </select>
        </div>
    </div>
    <div class="col-sm-7">
        <span class="fuente">
            <h3>Registro de pedidos: Gestión - <?php echo $year;?></h3>
        </span>
    </div>
</div>

<br>
<!-- TABLA -->
<table id="tabla1" class="content-table table table-hover text-center">
    <thead>
        <tr class="text-center">
            <th>Código</th>
            <th>CA</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Tipo pago</th>
            <th>Total</th>

            <!-- <th>Imprimir</th> -->
        </tr>
    </thead>

<tbody>
    <?php foreach($fila as $a  => $valor){ ?>
        <tr >
            <td><?php echo $valor["id"] ?></td>
            <td><?php echo $valor["ca"]?></td>
            <td><?php echo $valor["cliente"]?></td>
            <td><?php echo $valor["fecha"]?></td>
            <td><?php if($valor["credito"] == '1'){echo 'Crédito';}else{echo 'Contado';} ?></td>
            <td><?php echo $valor["total_cd"]?> Bs.</td>
        </tr>
    <?php } ?>  
</tbody>
</table>


</div>
</div>


<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
        "order": [[ 0, "desc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "Lo siento, no se encontraron datos",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay datos disponibles",
        "infoFiltered": "(filtrado de _MAX_ resultados)",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
        }
    });
});



//funcion periodo
function enviarfecha() {
    ges = $('#ges').val();
    $("#cuerpo").load("templates/pedidos/reg_pedidos.php?ges="+ges);
}

</script>























<!-- FALTA CREAR EL MODAL CON DETALLE DE PEDIDO Y OPCION DE ACEPTAR PEDIDO PARA LUEGO REGISTRARLO EN LA TABLA VENTAS. -->