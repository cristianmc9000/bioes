<?php 
	session_start();
	require('recursos/conexion.php');
	$salir = '<a href="recursos/salir.php" class="right" target="_self"><i class="material-icons">logout</i>Cerrar sesión</a>';
?>
<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#673ab7">
	<meta name="MobileOptimized" content="width">
	<meta name="HandheldFriendly" content="true">
	<link rel="icon" type="image/x-icon" href="img/iconobioesencia.ico">
	<link rel="manifest" href="./manifest.json">


	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
	<link rel="stylesheet" href="css/jquery.nice-number.css">
	<link rel="stylesheet" type="text/css" href="css/pedidos.css">
	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
	<!-- <link rel="stylesheet" href="css/viewpdf.css"> -->

  <script src="js/jquery-3.0.0.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/jquery.nice-number.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js" integrity="sha512-U5C477Z8VvmbYAoV4HDq17tf4wG6HXPC6/KM9+0/wEXQQ13gmKY2Zb0Z2vu0VNUWch4GlJ+Tl/dfoLOH4i2msw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
<!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&display=swap" rel="stylesheet"> -->

	<title>Distribuidora Carmina - Pedidos</title>
</head>
<style>
	.grande{
		font-size: 3rem !important;
		/*color: #2ecc71;*/
	}
	.semi{
		font-size: 1.5rem !important;
	}

  .get_out {
    left: 300px;
    top: 0;
    position: fixed;
    z-index: 999;
	}
	
	#back_expertas{
		float: left;
		position: relative;
		/*z-index: 1;*/
		/*height: 56px;*/
		margin: 0 18px;
	}
	.texto-blanco a, .texto-blanco i {
		color: #bdbdbd !important;
	}
	body{
		/*background-color: #424242;*/
	}
</style>

<body>
<div class="nav_container">
	<nav class="deep-purple lighten-1">
		<div class="nav-wrapper">
			<a href="#" id="menu" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			<a href="#" id="back_catalogo" hidden><i class="material-icons left" style="margin: 0 18px">keyboard_return</i></a>
			<a href="#" id="back_expertas" onclick="$('#cuerpo').load('templates/catalogos/expertas.php')" hidden><i class="material-icons left">keyboard_return</i></a>
			<a href="#" id="titulo" class="brand-logo center fuente">Dist. Carmina</a>
			<ul class="right">
				<li><a href="#" id="cart"><i class="grande material-icons"><img style="max-height: 40px;" src="images/icons/vacio.png"/></i></a></li>
			</ul>
		</div>
	</nav>

	<ul id="slide-out" class="sidenav sidenav-fixed roboto grey darken-4 text-lighten-4" >
	    <li>
	    	<div class="user-view">
		      <div class="background">
		        <img src="images/fondo1.jpg" height="100%" width="100%">
		      </div>
		      <div><center><a href="#user"><img class="circle" src="img/logo_bio.png"></a></center></div>
		      <a href="#name"><span class="white-text name"><b><?php echo $_SESSION['usuario']." ".$_SESSION['apellidos']?></b></span></a>
		      <a href="#email"><span class="white-text email"><b><?php echo "CA: ".$_SESSION['ca']?></b></span></a>
	    	</div>
	  	</li>
	  	<div class="texto-blanco">
		    <li><a href="#!" onclick="_load(`templates/catalogos/inicio`)" class="waves-effect waves-teal"><i class="material-icons">home</i>Catálogo</a></li>
		    <!-- <li><a href="#!" onclick="_load(`templates/catalogos/promos`)" class="waves-effect waves-teal"><i class="material-icons">star</i>Promociones</a></li> -->
		    <li><a href="#!" onclick="_load(`templates/catalogos/perfil`)" class="waves-effect waves-teal"><i class="material-icons">person</i>Mi perfil</a></li>
		    <li><a href="#!" onclick="_load(`templates/catalogos/mipedido`)" class="waves-effect waves-teal"><i class="material-icons">shopping_basket</i>Mi pedido</a></li>
		    <li><a href="#!" onclick="_load(`templates/catalogos/historial`)"class="waves-effect waves-teal"><i class="material-icons">assignment</i>Historial de pedidos</a></li>
		    <li <?php if($_SESSION['nivel'] == 'experta'){echo 'hidden';}?>><a href="#!" onclick="_load(`templates/catalogos/expertas`)"class="waves-effect waves-teal"><i class="material-icons">groups_2</i>Expertas</a></li>
		    <li <?php if($_SESSION['nivel'] == 'experta'){echo 'hidden';}?>><a href="#!" onclick="_load(`templates/catalogos/reportes`)"class="waves-effect waves-teal"><i class="material-icons">auto_stories</i>Reporte de expertas</a></li>
		    <li><div class="divider grey darken-3"></div></li>
		    <!-- <li><a class="subheader"></a></li> -->
		    <li><a class="waves-effect" href="recursos/catalogos/salir.php"><i class="material-icons">logout</i>Cerrar sesión</a></li>
	    </div>
	</ul>

</div>


<div id="cuerpo" class="row"> 

</div>

</body>
</html>
<script src="./script.js"></script>
<script>
	var reg_pedidos = new Array();
	$(document).ready(function(){
  	$('.sidenav').sidenav();
  	$("#cuerpo").load('templates/catalogos/inicio.php');

  });


document.getElementById('cart').addEventListener('click', () => {
	document.getElementsByClassName('div_paginador')[0].hidden = true;
	document.getElementById('cart').hidden = true
	// document.getElementById('form__').hidden = true
	document.getElementById('tabs_catalogo').hidden = true
	document.getElementById('cart_row').hidden = false
	document.getElementById('menu').hidden = true
	document.getElementById('back_catalogo').hidden = false;

});



	function _load (url) {
		let y = '.php';
		if (url == 'templates/catalogos/inicio') {
			document.getElementById('cart').hidden = false;
		}else{
			document.getElementById('cart').hidden = true;
		}
		
		if (screen.width < 993) {
			$(".sidenav").sidenav('close')
		}
		$("#cuerpo").load(url+y);
	}



</script>