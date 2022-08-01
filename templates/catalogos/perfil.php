<?php 
session_start();
require('../../recursos/conexion.php');
$ca = $_SESSION['ca'];
$nombre = $_SESSION['usuario'];
$apellidos = $_SESSION['apellidos'];



$result = $conexion->query("SELECT * FROM clientes WHERE ca = ".$ca);
$result = $result->fetch_all(MYSQLI_ASSOC);

$telf = $result[0]['telefono'];
$pass = $result[0]['password'];
$dir = $result[0]['lugar'];
?>

<style>
/*	#update{
		position: fixed;
	    bottom: 10%;
	    left: 50%;
	    -ms-transform: translate(-50%, -50%);
	    transform: translate(-50%, -50%);
	}*/
</style>

<div class="container">
<br>
  <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field">
        	<i class="material-icons prefix">pin</i>
			<input placeholder="Placeholder" id="ca" type="text" value="<?php echo $ca?>" class="validate" disabled>
			<label for="ca" class="active">Código Arbell:</label>
        </div>
        <div class="input-field">
        	<i class="material-icons prefix">person</i>
			<input id="nombre" type="text" value="<?php echo $nombre.' '.$apellidos?>" class="validate" disabled>
			<label for="nombre" class="active">Nombres y apellidos: </label>
        </div>

        <div class="input-field">
        	<i class="material-icons prefix">home</i>
			<input value="<?php echo $dir?>" id="dir" type="text" maxlength="100" class="validate">
			<label for="dir" class="active">Dirección:</label>
        </div>

        <div class="input-field">
        	<i class="material-icons prefix">call</i>
			<input value="<?php echo $telf?>" id="telf" type="number" class="validate">
			<label for="telf" class="active">Teléfono/celular:</label>
        </div>

 		<hr>

        
    	<div class="row">
        	<div class="col s10">
	        	<div class="input-field">
		        	<i class="material-icons prefix">key</i>
					<input id="password" maxlength="4" type="password" pattern="[0-9999]" inputmode="numeric" class="validate" value="<?php echo $pass?>" disabled>
					<label class="active" for="password" id="new_pass">Contraseña:</label>
				</div>
			</div>
			<div class="col s2">
				<div class="input-field">
					<a href="#" id="show_pass" class="btn waves-effect waves-light red lighten-2"><i class="material-icons">visibility</i></a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s10">
				<div class="input-field" id="rep" hidden>
					<i class="material-icons prefix">lock_reset</i>
					<input id="repita" maxlength="4" type="text" pattern="[0-9999]" value="<?php echo $pass?>" class="validate">
					<label for="repita">repita la contraseña:</label>
				</div>
			</div>	

			<div class="col s12 center">
				<div id="mod__pass"><a href="#" id="mod_pass" class="btn waves-effect waves-light red lighten-2">Modificar contraseña</a></div>
				<div id="hide__pass" hidden><a href="#" id="hide_pass" class="btn waves-effect waves-light red lighten-2">Cancelar</a></div>
			</div>
		</div>
        
		<hr>
		<br><br><br>
		<div class="col s12 center">
			<a href="#" id="update" class="btn-large waves-effect waves-light">Aceptar cambios</a>
		</div>


      </div>
    </form>
  </div>
        

</div>

<script>
	$(document).ready(function() {
		$("#titulo").html('Mi perfil');
	});

	$("#show_pass").on('click', function() {
		var tipo = document.getElementById("password");
		if(tipo.type == "password"){
			tipo.type = "text";
		}else{
			tipo.type = "password";
		}
	})

	$("#mod_pass").on('click', function() {
		$("#password").removeAttr('disabled');
		$("#mod__pass").hide();
		$("#hide__pass").show();
		$("#new_pass").html('Nueva contraseña');
		$("#repita").val('');
		$("#rep").show();
  	})
	$("#hide_pass").on('click', function() {
		document.getElementById('password').disabled = true;
		// $("#password").attr('disabled');
		$("#hide__pass").hide();
		$("#mod__pass").show();
		$("#new_pass").html('Contraseña');
		$("#password").val('<?php echo $pass?>');
		$("#repita").val('<?php echo $pass?>');
		$("#rep").hide();
  	})

	$("#update").on('click', function() {
		let dir = document.getElementById('dir').value;
		let telf = document.getElementById('telf').value;
		if (parseInt(telf) && (parseInt(telf)>10000000 && parseInt(telf)<99999999)) {
			telf = parseInt(telf);
		}else{
			return M.toast({html: 'Ingrese un número de teléfono válido.'});
		}
		let pass1 = document.getElementById('password').value;
		let pass2 = document.getElementById('repita').value;

		if (parseInt(pass1)>=1000 && parseInt(pass1) <= 9999) {
			if (parseInt(pass2) == parseInt(pass1)) {
				$.ajax({
				    url: "recursos/catalogos/password.php?password="+pass1+"&telf="+telf+"&dir="+dir,
				    method: "GET",
				    success: function(response) {
				        window.location.reload();
				    },
				    error: function(error) {
				        console.log(error)
				    }
				});
			}else{
				M.toast({html: 'Las contraseñas no coinciden.'})
			}
		}else{
			M.toast({html: 'La contraseña solo puede contener 4 dígitos numéricos.'})
		}

	});


  		    

</script>