    <?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');

/* $anio = $_GET["anio"]; */

// session_start();
/* $_SESSION['anio'] = $anio; */

// $Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, a.pupesos, a.pubs, a.cantidad, a.fechav FROM productos a, lineas b WHERE a.estado = 1 and a.linea = b.codli and fechareg LIKE '".$anio."-%-%' and periodo = ".$per; 

$Sql = "SELECT a.id, a.foto, b.nombre, b.codli, a.descripcion, c.cantidad, a.combo FROM productos a, lineas b, invcant c WHERE a.id = c.codp AND a.estado = 0 AND a.linea = b.codli"; 

$Busq = $conexion->query($Sql); 

if((mysqli_num_rows($Busq))>0){
  while($arr = $Busq->fetch_array()){ 

        $fila[] = array('id'=>$arr['id'], 'foto'=>$arr['foto'], 'linea'=>$arr['nombre'], 'codli'=>$arr['codli'], 'descripcion'=>$arr['descripcion'], 'cantidad'=>$arr['cantidad'], 'combo'=>$arr['combo']); 

  }
}else{
        $fila[] = array('id'=>'--','foto'=>'--','linea'=>'--','codli'=>'--','descripcion'=>'--','pupesos'=>'--','pubs'=>'--','cantidad'=>'--','combo'=>'--');
}

?>

<style>
    /* table.dataTable tbody th, table.dataTable tbody td {
      padding: 0;
    } */
    .izq{
    /*float: left;*/
    position: absolute;
    left: 10px;
    }
    .ui-autocomplete{
        z-index: 1099;
    }
    .ui-autocomplete-row
    {
      /*padding:8px;*/
      background-color: #f4f4f4;
      border-bottom:1px solid #ccc;
      font-weight:bold;
    }
    .ui-autocomplete-row:hover
    {
      background-color: #ddd;
      /*font-family: "Segoe UI Light"*/
    }
    .zoom {
        transition: transform .2s; 
    }

    .zoom:hover {
        transform: scale(1.3); 
    }

</style>
<div class="row">
    <div class="col-md-4">
      <span class="fuente"><h3>Productos eliminados</h3>
      </span>
    </div>

</div>
        <!-- TABLA -->
        <div class="row">
        <div class="col-md-11">
            <table id="tabla1" class="table content-table table-hover">
                <thead>
                    <tr>
                        <th>Ver</th>
                        <th>Código<br>(Producto)</th>
                        <th>Linea</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Restaurar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($fila as $a  => $valor){ ?>
                    <tr>
                        <td>
                          <img src="<?php echo $valor['foto']?>" width="50px" height="40px" alt="">
                        </td>
                        <td>
                            <?php echo $valor["id"] ?>
                        </td>
                        <td>
                            <?php echo $valor["linea"]?>
                        </td>
                        <td>
                            <?php echo $valor["descripcion"]?>
                        </td>
                        <td align="center">
                            <?php echo $valor["cantidad"] ?>
                        </td>
                        <td align="center">
                            <a href="#!" onclick="hab_producto('<?php echo $valor['id'] ?>');"><i class="material-icons">restore_from_trash</i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
        

<!-- MODAL RESTAURAR PRODUCTO-->
<div id="modal1" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Restaurar producto:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>El producto seleccionado será restaurado.</p>

            <input id="codpro" name="id" type="text" hidden>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="restaurar">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
    <div id="mensaje" class="modal-content" hidden></div>

<script>
var mensaje = $("#mensaje");
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
          }},
    });
});

function hab_producto(id) {
    $("#codpro").val(id)
    $("#modal1").modal('toggle')
}

$("#restaurar").click(function () {
    let id = $("#codpro").val()
    $.ajax({
        url: "recursos/productos/restaurar.php?id="+id,
        method: "GET",
        success: function(response) {
            console.log(response)
            if(response == 1){
                mtoast('Producto restaurado', 'success')
                $("#modal1").modal('toggle')
                $("#cuerpo").load('templates/productos/productos_eliminados.php')
            }
        },
        error: function(error) {
            console.log(error)
        }
    })
})


</script>

