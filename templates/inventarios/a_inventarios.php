<?php
require('../../recursos/conexion.php');
require('../../recursos/sesiones.php');
session_start();

if (isset($_GET["mes"])) {
  $per = $_GET["mes"];
  $Sql = "SELECT a.id, a.codp, c.nombre, b.descripcion, a.pupesos, a.pubs, a.cantidad, a.fecha_reg, a.fecha_venc FROM inventario a, productos b, lineas c WHERE b.linea = c.codli AND a.codp = b.id AND a.estado = 1 AND b.periodo = ".$per; 
}else{
    $per = "";
    $Sql = "SELECT a.id, a.codp, c.nombre, b.descripcion, a.pupesos, a.pubs, a.cantidad, a.fecha_reg, a.fecha_venc FROM inventario a, productos b, lineas c WHERE b.linea = c.codli AND a.codp = b.id AND a.estado = 1";
}

// $per = $_GET["mes"];
/* $anio = $_GET["anio"]; */

$_SESSION['periodo'] = $per;
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
<div class="col s11">
<div class=" col s4 ">
    <div class="col s3">
        <b style= "color:blue"> Periodo:</b>
        <select onchange="enviarfecha()" name="mes" id="mes" class="browser-default">
            <option value="0" selected disabled> Seleccionar</option>
            <option value="1"> 1 </option>
            <option value="2"> 2 </option>
            <option value="3"> 3 </option>
            <option value="4"> 4 </option>
            <option value="5"> 5 </option>
            <option value="6"> 6 </option>
            <!-- <option> Todos </option> -->
        </select>
    </div>
</div>
<div class="col s7 offset-s1">
<span class="fuente">
    <h3>
        Inventario: <?php if(isset($_GET["mes"])){echo $_GET["mes"];}else{echo "Total";}?>
    </h3>

</span>
</div>

<!-- TABLA -->
<table id="tabla1" class="highlight">
    <thead>
        <tr>
            <th>Código</th>
            <th>Linea<br>(Producto)</th>
            <th>Descripcion</th>
            <th>P.U.<br>(arg.)</th>
            <th>P.U.<br>(Bs.)</th>
            <th>Stock inicial <br>adquirido</th>
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
            <a href="#!" onclick="borrar_inventario('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a>
            </td>

        </tr>
    <?php } ?>  
</tbody>
</table>

<!--MODAL MODIFICAR INVENTARIO-->
<div class="row">
<div id="modal2" class="modal col s4 offset-s4">
  <div class="modal-content fuente fuente_azul" >
    <h4>Modificar producto</h4>  
    <div class="row">
        <form class="col s12" id="modificar_inventario">
            <div class="row">
                <div  class="input-field col s6">
                    <input name="pupesos" id="pup" onkeypress="return check(event)" type="text" required>
                    <label class="active" for="pupesos">P.U. (pesos arg.):</label>
                    <input type="text" id = "codigo" name= "id" hidden>
                </div>
            <div class="input-field col s6">
                <input name="pubs" onkeypress="return check(event)" id="pub" type="text" required>
                <label class="active" for="pubs">P.U. (Bs.):</label>
                </div>
            </div>
            <div class="row">  
                <div class="input-field col s6">
                <input id="cantidad" name="cantidad" type="number" required>
                <label class="active" for="cantidad">Cantidad: </label>
                <input type="text" id="cant_ant" name="cant_ant" hidden>
            </div>
            <div class="input-field col s6">
                <input id="fechav" name = "fechav" type="date">
                <label class="active" for="first_name">Fecha de vencimiento</label>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>



<!--MODAL BORRAR CLIENTE-->
<div class="row">
<div id="modal3" class="modal col s4 offset-s4">
  <div class="modal-content">
    <h4><b>Borrar Producto</b></h4>  
    <p>¿Esta seguro que desea eliminar este producto del inventario?</p>
    <div class="row">
      <form class="col s12" id="eliminar_inventario">
          <div class="row">
            <div class="input-field col s6" >
              <input id="datos_borrar" name="id" type="text" hidden>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
          </div>
      </form>
    </div>
  </div>
</div>
</div>


<!-- PARA RECIBIR MENSAJES DESDE PHP -->  
    <div id="mensaje" class="modal-content" hidden>

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
    $('#modal').leanModal();

});

function mod_inventario(id, pup, pub, cantidad, fecha_v) {
    $("#codigo").val(id)
    $("#pup").val(pup)
    $("#pub").val(pub)
    $("#cantidad").val(cantidad)
    $("#cant_ant").val(cantidad)
    $("#fechav").val(fecha_v)
    $("#modal2").openModal()
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
    
          if (echo.includes("?mes") || echo == "") {
              $("#modal2").closeModal(); 
              Materialize.toast("PRODUCTO MODIFICADO." , 4000);
              $("#cuerpo").load("templates/inventarios/a_inventarios.php"+echo);
            
          }
    });
});

function borrar_inventario(id){

  $("#datos_borrar").val(id)
  $('#modal3').openModal()
}
$("#eliminar_inventario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("eliminar_inventario"));
    $.ajax({
      url: "recursos/inventarios/borrarinventario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        // mensaje.show();
        console.log(echo);

        if (echo.includes("?mes")) {
          $("#modal3").closeModal(); 
          Materialize.toast("PRODUCTO ELIMINADO." , 4000);
          $("#cuerpo").load("templates/inventarios/a_inventarios.php"+echo);
        }
        
      }
    });
});



$("#pup").on("keydown input", function(e){
    pesos = $("#pup").val()
    bs = pesos * parseFloat($("#valor").val());
    $("#pub").val(bs.toFixed(1));


    // console.log(e.keyCode)
    // if ((e.keyCode > 48 && e.keyCode < 57) || e.keyCode == 190 || e.keyCode == 46) {
    //     return true
    // }else{
    //     return false
    // }

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
