<?php
require('../../recursos/conexion.php');
$_SESSION['filas'] = array(); 
$Sql = "SELECT * FROM usuarios"; 
$Busq = $conexion->query($Sql); 
while($arr = $Busq->fetch_array()) 
    { 
        $fila[] = array('ci'=>$arr['CI'], 'nombre'=>$arr['nombre'], 'apellidos'=>$arr['apellidos'], 'telefono'=>$arr['telefono'],'password'=>$arr['password'],'rol'=>$arr['rol']);
        array_push($_SESSION['filas'],$fila); 
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
<span class="fuente"><h3>Usuarios	
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn-floating btn-large red" id="modal" href="#modal1"><i class="material-icons left">add</i></a></h3> 
</span>
  <!-- TABLA -->
  <div class="row">
    <div class="col s11">
      <table id="tabla1" class="highlight">
        <thead>
          <tr>
              <th>CI</th>
              <th>Nombres y apellidos</th>
              <th>Telefono</th>
              <th>Rol</th>
              <th>Modificar</th>
              <!-- <th>Borrar</th> -->
          </tr>
        </thead>
        <tbody>
        <?php foreach($fila as $a  => $valor){ ?>
          <tr>
            <td><?php echo $valor["ci"] ?></td>
            <td><?php echo $valor["nombre"]." ".$valor["apellidos"] ?></td>
            <td><?php echo $valor["telefono"] ?></td>
            <td><?php if($valor['rol'] == '1') {echo 'Administrador';}else{echo 'Vendedor';}?></td>
            <td><a href="#!" onclick="modificar_usuario('<?php echo $valor['ci']?>','<?php echo $valor['nombre']?>','<?php echo $valor['apellidos']?>','<?php echo $valor['telefono']?>','<?php echo $valor['rol']?>')"><i class="material-icons">build</i></a></td>
            <!-- <td><a href="#"><i class="material-icons">delete</i></a></td>         -->
          </tr>
        <?php } ?>	
        </tbody>
      </table>
    </div>
  </div>
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
                <input name="apellidos" type="text" value="" autocomplete="off">
                <label for="apellidos">Apellidos:</label>
              </div>
            </div>             
            <div class="row">
              <div class="input-field col s6">
                <input name="password" type="password" value="" autocomplete="new-password">
                <label for="password">Contraseña:</label>
              </div>
              <div class="input-field col s6">
                  <input name="password1" type="password">
                  <label for="password1">Repita la contraseña:</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="rol" class="browser-default">
                    <option value="1">Administrador</option>
                    <option value="2" selected>Vendedor</option>
                </select>
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

<!-- -----------modal modificar usuario------------ -->
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div class="modal-content">
      <h4>Modificar usuario</h4>
        <div class="row">
          <form id="modificar_usuario" class="col s12">
            <div class="row">
              <div class="input-field col s6">
                <input id="m_ci" name="ci" type="text" class="validate">
                <label class="active" for="ci">Cédula de Identidad:</label>
              </div>
              <div class="input-field col s6">
                <input id="m_telefono" name="telefono" type="number" class="validate">
                <label class="active" for="telefono">Teléfono:</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <input id="m_nombre" name="nombre" type="text" class="validate">
                <label class="active" for="nombre">Nombre:</label>
              </div>
              <div class="input-field col s6">
                <input id="m_apellidos" name="apellidos" type="text" value="" autocomplete="off">
                <label class="active" for="apellidos">Apellidos:</label>
              </div>
            </div>             
            <div class="row">
              <div class="input-field col s6">
                <input id="m_password" name="password" type="password" value="" autocomplete="new-password">
                <label for="password">Nueva Contraseña:</label>
                <small class="helper-text" style="color: red">Dejar en blanco si no desea modificar</small>
              </div>
              <div class="input-field col s6">
                  <input id="m_password1" name="password1" type="password">
                  <label for="password1">Repita la contraseña:</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select id="rol" name="rol" class="browser-default">
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn waves-effect waves-light" type="submit">Aceptar</button>
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

/* borrar usuario */
// function borrar_cliente(id){
//   document.getElementById("datos_borrar").innerHTML ='<input type="text" name="id" value="'+id+'" hidden/>';
//   $('#modal4').openModal();
// }


function modificar_usuario(ci, nombre, apellidos, telefono, rol){
  $("#m_ci").val(ci)
  $("#m_telefono").val(telefono)
  $("#m_nombre").val(nombre)
  $("#m_apellidos").val(apellidos)
  let selad = ""
  let selve = ""
  if (rol == 1) {selad = 'selected'}
  else{selve = 'selected'}
  document.getElementById('rol').innerHTML = `<option value="1" ${selad}>Administrador</option><option value="2" ${selve}>Vendedor</option>`;

  $("#modal2").openModal()
}
/* agregar usuario */
$("#modificar_usuario").on("submit", function(e){
    e.preventDefault();
    var val = new FormData(document.getElementById("modificar_usuario"));
    $.ajax({
      url: "recursos/usuarios/modificar_usuario.php",
      type: "POST",
      dataType: "HTML",
      data: val,
      cache: false,
      contentType: false,
      processData: false
    }).done(function(echo){
        console.log(echo)
        mensaje.html(echo)
        if (echo == 1) {
          Materialize.toast("<b>Usuario modificado.</b>",5000)
          $("#modal2").closeModal()
          $("#cuerpo").load("templates/usuarios/a_usuarios.php")
        }
    });
});
</script>
</body>
</html>