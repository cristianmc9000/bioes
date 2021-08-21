<?php
//Iniciamos la sesión
session_start();
//Pedimos el archivo que controla la duración de las sesiones
require('recursos/sesiones.php');
?>
<!DOCTYPE html>

<head>
	<title>login</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" type="image/x-icon" href="img/iconoarbell.ico" />
	<link rel="stylesheet" href="css/master.css">
	<link rel="icon" href="img/iconoarbell.ico"></link>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/datatable.css">
  	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	
	<script src="js/datatable.js"></script>
</head>
<style>
	@import url('https://fonts.googleapis.com/css?family=Rubik&display=swap');

	.login-box {
		background-color: transparent !important;
	}
	body{
		font-family: 'Belina Demo';
		src: url('fonts/belina/BelinaDemo-Regular.ttf'), url('fonts/Evergreen/Evergreen.otf'), url('fonts/fortunates	/Fortunates December.ttf');

	}

</style>

<body>
	<div class="login-box">
		<img class="avatar" src="img/logoarbell.png" alt="Logo Arbell">
		<h1>Ingresar al Sistema</h1>
		<div class="formulario-acceso">
			<form method="POST" id="acceso" action="" accept-charset="utf-8">
				<!-- Usuario -->
				<label for="username">Usuario</label>
				<input style="color: white" type="text" placeholder="Ingresar Usuario" name="userAcceso" class="acceso validate" id="userAcceso" autocomplete="off" maxlength="20">
				<!-- Contrasseña -->
				<label for="password">Password</label>
				<input style="color: white" type="password" placeholder="Ingresar Password" name="passAcceso" class="acceso" id="passAcceso" autocomplete="off" maxlength="20">
				<!-- boton ingresar -->
				<input type="submit" name="acceso" value="Ingresar" style="cursor: pointer">
			</form>
		</div>
	</div>
	<div id="mensaje"></div>
	<script>
		//Guardamos el controlador del div con ID mensaje en una variable
		var mensaje = $("#mensaje");
		//Ocultamos el contenedor
		mensaje.hide();
		//Cuando el formulario con ID acceso se envíe...
		$("#acceso").on("submit", function(e) {
			//Evitamos que se envíe por defecto
			e.preventDefault();
			//Creamos un FormData con los datos del mismo formulario
			var formData = new FormData(document.getElementById("acceso"));
			//Llamamos a la función AJAX de jQuery
			$.ajax({
				//Definimos la URL del archivo al cual vamos a enviar los datos
				url: "recursos/acceder.php",
				//Definimos el tipo de método de envío
				type: "POST",
				//Definimos el tipo de datos que vamos a enviar y recibir
				dataType: "HTML",
				//Definimos la información que vamos a enviar
				data: formData,
				//Deshabilitamos el caché
				cache: false,
				//No especificamos el contentType
				contentType: false,
				//No permitimos que los datos pasen como un objeto
				processData: false
			}).done(function(echo) {
				//Una vez que recibimos respuesta
				//comprobamos si la respuesta no es vacía
				if (echo != "") {
					//Si hay respuesta (error), mostramos el mensaje
					mensaje.html(echo);
				} else {
					//Si no hay respuesta, redirecionamos a donde sea necesario
					//Si está vacío, recarga la página
					window.location.replace("index.php");
				}
			});
		});
	</script>
</body>

</html>