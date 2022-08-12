<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();

// if (isset($_GET["mes"])) {
    // $per = $_GET["mes"];
    // $Sql = "SELECT a.id, a.codp, c.nombre, b.descripcion, a.pupesos, a.pubs, a.cantidad, a.fecha_reg, a.fecha_venc FROM inventario a, productos b, lineas c WHERE b.linea = c.codli AND a.codp = b.id AND a.estado = 1 AND b.periodo = ".$per; 
// }else{
$per = "";
$Sql = "SELECT a.id, a.codp, c.nombre, b.descripcion, a.pupesos, a.pubs, a.cantidad, a.fecha_reg, a.fecha_venc FROM inventario a, productos b, lineas c WHERE b.linea = c.codli AND a.codp = b.id AND b.combo = 0 AND a.estado = 1";
// }

// $per = $_GET["mes"];
/* $anio = $_GET["anio"]; */

// $_SESSION['periodo'] = $per;
/* $_SESSION['anio'] = $anio; */
//consultas a base de datos

//consulta tabla inventario

$Busq = $conexion->query($Sql); 
if((mysqli_num_rows($Busq))>0){
    while($arr = $Busq->fetch_array()){ 
        $fila[] = array('id'=>$arr['id'], 'codp'=>$arr['codp'], 'linea'=>$arr['nombre'], 'descripcion'=>$arr['descripcion'], 'pupesos'=>$arr['pupesos'], 'pubs'=>$arr['pubs'], 'cantidad'=>$arr['cantidad'], 'fecha_reg'=>$arr['fecha_reg'], 'fecha_venc'=>$arr['fecha_venc']); 
    }
}else{
        $fila[] = array('id'=>'--','codp'=>'--','linea'=>'--','descripcion'=>'--','pupesos'=>'--','pubs'=>'--','cantidad'=>'--','fecha_reg'=>'--','fecha_venc'=>'--');
}
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
    <!-- <div class=" col-sm-3"> -->
        <!-- <div class="col s3"> -->
            <!-- <span><b style= "color:blue"> Periodo:</b></span> -->
            <!-- <select onchange="enviarfecha()" name="mes" id="mes" class="form-select"> -->
                <!-- <option value="0" selected disabled> Seleccionar ...</option> -->
                <!-- <option value="1"> 1 </option> -->
                <!-- <option value="2"> 2 </option> -->
                <!-- <option value="3"> 3 </option> -->
                <!-- <option value="4"> 4 </option> -->
                <!-- <option value="5"> 5 </option> -->
                <!-- <option value="6"> 6 </option> -->
                <!-- <option> Todos </option> -->
            <!-- </select> -->
        <!-- </div> -->
    <!-- </div> -->
    <div class="col-sm-12 text-center">
        <span class="fuente">
            <h3>
                <!-- Inventario: <?php if(isset($_GET["mes"])){echo $_GET["mes"];}else{echo "Total";}?> -->
                Inventario total
            </h3>
        </span>
    </div>
    <br><br>
    <!-- TABLA -->
    <table id="tabla1" class="content-table table table-hover">
        <thead>
            <tr>
                <th>Código</th>
                <th>Linea<br>(Producto)</th>
                <th>Descripcion</th>
                <th>P.U.<br>(arg.)</th>
                <th>P.U.<br>(Bs.)</th>
                <th>Stock</th>
                <th>Fecha de <br> Registro </th>
                <th>Fecha de <br> Vencimiento </th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($fila as $a  => $valor){ ?>
                <tr>
                    <td><?php echo $valor["codp"] ?></td>
                    <td><?php echo $valor["linea"]?></td>
                    <td><?php echo $valor["descripcion"]?></td>
                    <td><?php echo $valor["pupesos"]?>$</td>
                    <td><?php echo $valor["pubs"] ?>Bs.</td>
                    <td><?php echo $valor["cantidad"] ?></td>
                    <td><?php echo $valor["fecha_reg"]?></td>
                    <td><?php echo $valor["fecha_venc"]?></td>
                    <td>
                    <a href="#!" onclick="mod_inventario('<?php echo $valor['id']?>','<?php echo $valor['pupesos']?>','<?php echo $valor['pubs']?>','<?php echo $valor['cantidad']?>','<?php echo $valor['fecha_venc']?>')"><i class="material-icons">build</i></a>
                    <!-- <a href="#!"><i class="material-icons">build</i></a> -->
                    </td>
                    <td>
                    <a href="#!" onclick="borrar_inventario('<?php echo $valor['id'] ?>', '<?php echo $valor['codp'] ?>');"><i class="material-icons">delete</i></a>
                    </td>

                </tr>
            <?php } ?>  
        </tbody>
    </table>
</div>

<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
<div id="mensaje" class="modal-content" hidden></div>


<!--MODAL MODIFICAR INVENTARIO-->
<div id="modal2" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modificar_inventario">
                    <div class="row g-3">
                        <div  class="col-sm-6">
                            <label class="form-label small text-muted" for="pupesos">P.U. (pesos arg.):</label>
                            <input name="pupesos" id="pup" class="form-control" onkeypress="return check(event)" type="text" required>
                            <input type="text" id = "codigo" name= "id" hidden>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small text-muted" for="pubs">P.U. (Bs.):</label>
                            <input name="pubs" id="pub" class="form-control" onkeypress="return check(event)"  type="text" required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label small text-muted" for="cantidad">Cantidad: </label>
                            <input id="cantidad" class="form-control" name="cantidad" type="number" required>
                            <input type="text" id="cant_ant" name="cant_ant" hidden>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small text-muted" for="first_name">Fecha de vencimiento</label>
                            <input id="fechav" class="form-control" name="fechav" type="date">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="modificar_inventario">Modificar</button>
            </div>     
        </div>
    </div>
</div>




<!--MODAL BORRAR CLIENTE-->
<div id="modal3" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro que desea eliminar este producto del inventario?</p>
                <input id="datos_borrar" name="id" type="text" hidden>
                <input id="datos_codp" type="text" hidden>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="eliminar_inventario()">Aceptar</button>
            </div>
        </div>
    </div>
</div>



<script>

var mensaje = $("#mensaje");
$(document).ready(function() {
    $('#tabla1').dataTable({
        "order": [[ 6, "desc" ]],
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
    $('.modal').modal();

});

function mod_inventario(id, pup, pub, cantidad, fecha_v) {
    $("#codigo").val(id)
    $("#pup").val(pup)
    $("#pub").val(pub)
    $("#cantidad").val(cantidad)
    $("#cant_ant").val(cantidad)
    $("#fechav").val(fecha_v)
    $("#modal2").modal('toggle')
}

$("#modificar_inventario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_inventario"));
    $.ajax({
      url: "recursos/inventarios/modificar_inventario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        if (echo == '1') {
            $("#modal2").modal('toggle'); 
            mtoast("PRODUCTO MODIFICADO." , 'success');
            $("#cuerpo").load("templates/inventarios/a_inventarios.php");  
        }else{
            console.log(echo)
        }
    });
});

function borrar_inventario(id, codp){

  $("#datos_borrar").val(id)
  $("#datos_codp").val(codp)
  $('#modal3').modal('toggle')
}

function eliminar_inventario() {
    let id = $("#datos_borrar").val()
    let codp = $("#datos_codp").val()
    $.ajax({
        url: "recursos/inventarios/borrarinventario.php?id="+id+"&codp="+codp,
        method: "GET",
        success: function(response) {
            if (response == 1) {
                console.log(response)
                $("#modal3").modal('toggle'); 
                mtoast("PRODUCTO ELIMINADO." , 'success');
                $("#cuerpo").load("templates/inventarios/a_inventarios.php");
            }else{
                console.log(response)
            }
        },
        error: function(error) {
            console.log(error)
        }
    });
}


$("#pup").on("keydown input", function(e){
    pesos = $("#pup").val()
    bs = pesos * parseFloat($("#valor").val());
    $("#pub").val(Number(bs.toFixed(1)));
})

$("#pub").on("keydown input", function(e){
    bs = $("#pub").val()
    pesos = bs / parseFloat($("#valor").val());
    $("#pup").val(Number(pesos.toFixed(1)));
})

//funcion periodo
function enviarfecha() {
    mes = $('#mes').val();
    let anio = 2021;
    $("#cuerpo").load("templates/inventarios/a_inventarios.php?mes="+mes);
}

</script>

</div>
</div>
