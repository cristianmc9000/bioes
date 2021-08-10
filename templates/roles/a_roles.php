<?php
require('../../recursos/conexion.php');

$Sql = "SELECT * FROM rol"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('id_rol'=>$arr['id_rol'], 'rol'=>$arr['rol'],'descripcion'=>$arr['descripcion']); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>
  .fuente{
  	font-family: 'Segoe UI light';
  	color: red;
  }


  table.highlight > tbody > tr:hover {
    background-color: #a0aaf0 !important;
  }

  #tabla1{
  	border-collapse: separate;
  	border-radius: 5px;
  	border-spacing: 1px;
  	border: solid;
  	border-color: #1f1f1f;
  }
  .fijo{
    position: fixed !important;
    right: 10px;
    bottom: 5%;
    max-width: 230px;
    z-index: 10 !important;
    width: 230px;

  }
  .fijo:hover{
    background: #ffffff;
    margin-right:40px;
  }
</style>

</head>
<body>

<span class="fuente"><h3>Roles	
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a></h3> 
</span>

  <!-- TABLA -->

  <table id="tabla1" class="highlight">
    <thead>
      <tr>
          <th>ID_Rol</th>
          <th>Rol</th>
          <th>Descripcion</th>
          <th>Modificar</th>
          <th>Borrar</th>

      </tr>
    </thead>

    <tbody>
    <?php foreach($fila as $a  => $valor){ ?>
      <tr>
        <td><?php echo $valor["id_rol"] ?></td>
        <td><?php echo $valor["rol"] ?></td>
        <td><?php echo $valor["descripcion"]?></td>
        <td>
        <!-- <a href="#!" onclick="mod_producto('<?php echo $valor['foto']?>','<?php echo $valor['id_rol']?>','<?php echo $valor['rol'] ?>','<?php echo $valor['codli'] ?>','<?php echo $valor['descripcion'] ?>','<?php echo $valor['pupesos']?>','<?php echo $valor['pubs']?>','<?php echo $valor['cantidad']?>','<?php echo $valor['fechav']?>')"><i class="material-icons">build</i></a> -->
        <!-- <a href="#!"><i class="material-icons">build</i></a> -->
      </td>
      <td>
        <!-- <a href="#!" onclick="borrar_producto('<?php echo $valor['id'] ?>');"><i class="material-icons">delete</i></a> -->
      </td>



      </tr>
    <?php } ?>	
    </tbody>
  </table>


<!-- MODAL DATOS -->
<div class="row">
  <div id="modal1" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h4>Agregar usuario</h4>
        <div class="row">
          <form id="agregar_usuario" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <input name="ci" type="text" class="validate">
                <label for="ci">Cédula de Identidad:</label>
              </div>
              <div class="input-field col s6">
                <input name="telefono" type="number" class="validate">
                <label for="telefono">Teléfono:</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <input name="nombre" type="text" class="validate">
                <label for="nombre">Nombre:</label>
              </div>
              <div class="input-field col s6">
                <input name="apellidos" type="text" value="">
                <label for="apellidos">Apellidos:</label>
              </div>
            </div>             
            <div class="row">
              <div class="input-field col s6">
                <input name="password" type="password" value="">
                <label for="password">Contraseña:</label>
              </div>
              <div class="input-field col s6">
                  <input name="password1" type="password">
                  <label for="password1">Repita la contraseña:</label>
              </div>
            </div>

            <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
              <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
            </div>

          </form>
        </div>
    </div>
              
  </div>
</div>


<div id="mensaje"></div>


<!-- -----------------CRUD DE USUARIOS------------------------ -->
<script>
$(document).ready(function() {
    $('#tabla1').dataTable({
      "order": [[ 0, "desc" ]],
      "language": {
      "lengthMenu": "Registros por página: _MENU_",
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
var mensaje = $("#mensaje");
mensaje.hide();


/* agregar usuario */
$("#agregar_usuario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("agregar_usuario"));
    $.ajax({
      url: "recursos/usuarios/agregar_usuario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        mensaje.show();

        $("#cuerpo").load("templates/usuarios/a_usuarios.php");

      }
    });
});

/* modificar usuario */
$("#modificar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_cliente"));
    $.ajax({
      url: "recursos/modcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("clientes.php");
      }
    });
});

/* borrar usuario */
function borrar_cliente(id){

  document.getElementById("datos_borrar").innerHTML ='<input type="text" name="id" value="'+id+'" hidden/>';
  $('#modal4').openModal();
}
$("#borrar_cliente").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("borrar_cliente"));
    $.ajax({
      url: "recursos/borrarcliente.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
      if (echo !== "") {
        mensaje.html(echo);
        $("#cuerpo").load("clientes.php");      }
    });
});


</script>


</body>
</html>