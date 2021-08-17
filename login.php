<?php
//Iniciamos la sesión
session_start();
//Pedimos el archivo que controla la duración de las sesiones
require('recursos/sesiones.php');
?>
<!DOCTYPE html>

<head>
	<title>login</title>
	<link rel="icon" href="img/iconobioesencia.ico"></link>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<!-- hoja de estilo css -->
	<link rel="stylesheet" href="style.css">
</head>

<body class="bg-dark">

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

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>
