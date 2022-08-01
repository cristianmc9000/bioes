<?php 
	session_start();
	$salir = '<a href="recursos/salir.php" class="right" target="_self"><i class="material-icons">logout</i>Cerrar sesión</a>';
?>
<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" >
	<link rel="stylesheet" href="css/jquery.nice-number.css">
	<link rel="stylesheet" href="css/pedidos.css">
	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
		integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous"
		referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="css/viewpdf.css">

  <script src="js/jquery-3.0.0.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/jquery.nice-number.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"
		integrity="sha512-U5C477Z8VvmbYAoV4HDq17tf4wG6HXPC6/KM9+0/wEXQQ13gmKY2Zb0Z2vu0VNUWch4GlJ+Tl/dfoLOH4i2msw==" crossorigin="anonymous"
		referrerpolicy="no-referrer"></script>

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
	.contenedor{
		/*margin-top: 5%;*/
		/*display: flex;*/
		/*gap: 20px;*/
	}

	.font_black{
		/*color: black !important;*/
	}

	.ui-autocomplete-row{
    padding: 8px;
    background-color: #f4f4f4;
    border-bottom:1px solid #ccc;
    font-weight:bold;
    display: flex;
    align-items: center;
  }
  .ui-autocomplete-row:hover{
    background-color: #ddd;
  }
  .zoom {
  transition: transform .2s; 
  }

  .zoom:hover {
    transform: scale(1.8); 
  }

  .get_out {
    left: 300px;
    top: 0;
    position: fixed;
    z-index: 999;
	}
	#modal1{
		min-height: 80%;
		height: 80%;
	}
	#modal1-content{
		min-height: 90%;
		height: 90%;
	}
	#modal2{
		/*position: absolute;*/
		/*top: 0% !important;*/
		min-height: auto;
		height: auto;
	}
	#modal2-content{
		min-height: auto;
		height: auto;
	}
	#contenedor_foto{
		min-width: 60%;
		max-width: 60%;
	}
	.ui-menu{
		font-size: 1.3rem !important;
  	z-index: 9999;
	}
	@media only screen and (max-width : 992px) {
	.get_out {
		left: 0;
		top: 0;
		position: fixed;
		z-index: 999;
	}
	#btn_eliminar_experta{
		min-height: 100%;
		display: flex;
		align-items: center;
		position: absolute;
		right: 5px;
	}

	#modal1{
		/*position: absolute;*/
		/*top: 0% !important;*/
		min-height: auto;
		height: auto;
	}
	#modal1-content{
		min-height: auto;
		height: auto;
	}
	#modal2{
		/*position: absolute;*/
		top: 0% !important;
		min-height: 85%;
		height: 85%;
	}
	#modal2-content{
		min-height: 90%;
		height: 90%;
	}
	#contenedor_foto{
		min-width: auto;
		max-width: 100%;
	}
}

</style>

<body>
<div class="nav_container">
	<nav>
		<div class="nav-wrapper">
			<a href="#" id="menu" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			<a href="#" id="titulo" class="brand-logo center dancing">Distrib. Carmina</a>
			<ul class="right">
				<li><a href="#" id="cart"><i class="grande material-icons"><img style="max-height: 40px;" src="images/icons/vacio.png"/></i></a></li>
			</ul>
		</div>
	</nav>

	<ul id="slide-out" class="sidenav sidenav-fixed roboto">
	    <li><div class="user-view">
	      <div class="background">
	        <img src="images/fondo4.jpg" height="100%" width="100%">
	      </div>
	      <a href="#user"><img class="circle" src="images/logo_sin_fondo.png"></a>
	      <a href="#name"><span class="white-text name"><b><?php echo $_SESSION['usuario']." ".$_SESSION['apellidos']?></b></span></a>
	      <a href="#email"><span class="white-text email"><b><?php echo "CA: ".$_SESSION['ca']?></b></span></a>
	    </div></li>
	    <li><a href="#!" onclick="window.location.reload()" class="waves-effect waves-teal"><i class="material-icons">home</i>Inicio</a></li>
	    <li><a href="#!" onclick="_load(`templates/catalogos/perfil`)" class="waves-effect waves-teal"><i class="material-icons">person</i>Mi perfil</a></li>
	    <li><a href="#!" onclick="_load(`templates/catalogos/mipedido`)" class="waves-effect waves-teal"><i class="material-icons">shopping_basket</i>Mi pedido</a></li>
	    <li><a href="#!" onclick="_load(`templates/catalogos/historial`)"class="waves-effect waves-teal"><i class="material-icons">assignment</i>Historial de pedidos</a></li>
	    <li <?php if($_SESSION['nivel'] == 'experta'){echo 'hidden';}?>><a href="#!" onclick="_load(`templates/catalogos/expertas`)"class="waves-effect waves-teal"><i class="material-icons">groups_2</i>Expertas</a></li>
	    <li><div class="divider"></div></li>
	    <!-- <li><a class="subheader"></a></li> -->
	    <li>
	    	<div class="input-field container" hidden>
			    <select class="browser-default">
			      <option value="" disabled selected>Seleccione el catálogo</option>
			      <option value="1">Option 1</option>
			      <option value="2">Option 2</option>
			      <option value="3">Option 3</option>
			    </select>

			  </div>
	    </li>	
	    <li><a class="waves-effect" href="recursos/catalogos/salir.php"><i class="material-icons">logout</i>Cerrar sesión</a></li>
	</ul>
</div>

<!-- <div class="row" style="margin-bottom: 0px;">
	<div class="input-field col s10 offset-s1">
	    <select>
	      <option value="" disabled selected >Selecciona el catálogo</option>
	      <option value="1">Catálogo 55</option>
	      <option value="2">Catálogo 58</option>
	      <option value="3">Catálogo 60</option>
	    </select>
	   <label>Selecciona el catálogo</label>
	</div>
</div> -->


<!-- FORMULARIO PARA SUBIR CATÁLOGOS -->
<!-- <div class="container">
    <form class="col s12" id="load_pdf">
      <div class="row">
        <div class="input-field file-field col s6">
          <div class="btn">
            <span>Foto</span>
            <input type="file" name="pdf">
          </div>
          <div class="file-path-wrapper">
            <input id="foto" class="file-path validate" type="text">
          </div>
        </div>
      </div>

      <div class="modal-footer">
          <button class="btn waves-effect waves-light" type="submit" >Aceptar</button>
          <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Cancelar</a>
      </div>
  	</form>
</div> -->


<div id="cuerpo" class="row"> 

	<div class="contenedor col s12 m6" id="pdf_container">
		<div id="princ" class="">
				<img width="95%" id="img_container" src="images/catalogos/Catalogo_02-2022_2_page-0001.jpg" alt="">
		</div>
		<div id="foot">
			<ul style="margin-top: 0px;margin-bottom: 0px;">
				<li>
					<button id="openPDF" hidden>
						<span>Open</span> <i class="fas fa-folder-open"></i>
					</button>
					<input type="file" id="inputFile" hidden>
				</li>
				<li class="pagination">
					<button id="previous"><i class="fas fa-arrow-alt-circle-left"></i></button>
					<span id="current_page">0</span>
					<button id="next"><i class="fas fa-arrow-alt-circle-right"></i></button>
				</li>

				<li hidden>
					<span id="zoomValue">150%</span>
					<input type="range" id="zoom" name="cowbell" min="100" max="300" value="150" step="50" disabled>
				</li>
			</ul>
		</div>
	</div>

	<div id="form__">
		<div class="container col s12 m6" id="form_container">
			<!-- <div class="row">	 -->
				<div class="input-field col s5 m6 offset-m3">
			        <input id="search_data" type="text" autocomplete="off" class="validate semi" required>
			        <label for="search_data">Código producto</label>
			  </div>
				<div class="input-field col s2 m4 offset-m4" style="text-align: center;" >
					<!-- aqui va el código de la imagen. -->
					<img id="img_prod" src="images/fotos_prod/default.png" alt="" style="width: 100%; border-radius: 10px;">
					<small class="fuente" style="line-height: 0px;"><b id="cod_prod"></b></small>
				</div>
				<div class="input-field col s4 offset-s1 m12" id="div_cantidad" hidden>
					<div class="number-container">
						<!-- <label for="">Cantidad</label> -->
						<input class="browser-default" type="number" name="" id="__cantidad" min="1" max="100" disabled>
					</div>
				</div>
				<div id="__datosprod" hidden><input id='__datosp' cp='1' hidden/></div>
			<!-- </div> -->
		</div>

		<div class="container center col s12 m6" style="padding-top: 2em;" id="add_container">
			<a class="waves-effect waves-light btn-large shop red lighten-1 fuente" id="add"><i class="material-icons right">add_shopping_cart</i>Agregar al carrito</a>
		</div>
	</div>

	<div class="container">
		<div class="row roboto" id="cart_row" hidden>
			<div class="row get_out">
				<div class="left">
					<a href="#!" class="btn-large red lighten-2" id="return"><i class="material-icons">keyboard_return</i></a>
				</div>
			</div>
			<!-- antes era col s12 m12 l4 xl5 -->
			<div class="col s12 m12 l12" id="div_tabla_pedidos"> <!-- style="margin-top: -8%;" -->
				<!-- <div class="col l6 m10 offset-m1 s12"> -->
					<div class="center"><h4>Tu pedido</h4></div>

					<table id="pedidos_cliente" class="content-table centered z-depth-4">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Precio</th>
								<th>Borrar</th>
							</tr>
						</thead>
						<tbody style="font-size: 0.9em">
							<td colspan="4">Aún no has agregado ningún producto.</td>
						</tbody>
					</table>

					<hr>
					<div class="row">
						<!-- <div class="col m6 offset-m6 s4 offset-s6"> -->
							<div class="neon container" >
								<p>Subtotal: <label id="total_ped" class="neon">0.00 Bs</label></p>
								<p>Total con descuento: <label id="total_ped_cd" class="neon">0.00 Bs</label></p>
							</div>
						<!-- </div> -->
					</div>
				<!-- </div> -->
			</div>
			<div class="col s12">
				<p>
		      <label>
		        <input type="checkbox" id="pago" />
		        <span>Compra a crédito.</span>
		      </label>
		    </p>
			</div>
			<div class="center">
				<a class="waves-effect waves-light btn btn-large disabled" id="mod_con">PEDIR!</a>
			</div>
		</div>
	</div>

  <!-- Modal Structure - detalle de producto -->
  <div id="modal1" class="modal fuente modal_prod">
    <div class="modal-content" id="modal1-content" style="padding-bottom: 0px;">
      
      <div class="center">
      	<h6 id="modal_title"  style=" font-weight: bold;"></h6>
      	<div id="contenedor_foto" style="margin: auto">
      		<img id="modal_foto" src="images/fotos_prod/default.png" width="100%" alt="">
      	</div>
      </div>
      <div style="line-height: 0.5em">
      	<p id="modal_cod"></p>
      	<p id="modal_pu"></p>
    	</div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn right">Aceptar</a>
    </div>
  </div>

  <!-- Modal Structure - confirmación de pedidos -->
  <div id="modal2" class="modal roboto modal_prod">
    <div class="modal-content" id="modal2-content">
      
      <div class="center">
      	<h6 id="modal_title" class="rubik" style=" font-weight: bold;">DETALLE DEL PEDIDO</h6><br>
      </div>

	  	<!-- <div class="row"> -->

				<div <?php if($_SESSION['nivel'] == 'experta'){echo 'hidden';}?>>
					<p>
			      <label>
			        <input type="checkbox" id="check_pedido_experta" />
			        <span>Pedir para mi experta</span>
			      </label>
			    </p>
		    </div>

			    <div id="pedido_experta_container" style="position: relative;" class="col s12" hidden>
				    <div class="input-field col s7">
				    	<input type="text" id="input_pedido_experta" autocomplete="off">
				    	<label for="input_pedido_experta">Buscar experta...</label>
				    </div>
				    <div class="input-field col s4">
				    	<input type="text" id="input_ca_pedido_experta" value="" disabled>
				    	<label class="active" for="input_ca_pedido_experta">Código:</label>
				    </div>
				    <div id="btn_eliminar_experta" class="col s1">
	            <a href="#" style="color: red" id="a_eliminar_experta"><i class="material-icons">close</i></a>
	          </div>
			    </div>

			<!-- </div> -->

      <div>
      	
      		<div hidden>
	      		<input type="text" id="input_cant">
	      		<input type="text" id="input_total">
	      		<input type="text" id="input_total_cd">
	      	</div>
					<table class="det rubik z-depth-4">
						<tr>
							<th width="30%">Fecha: </th>
							<td><span id="conf_fecha"></span></td>
						</tr>
						<tr>
							<th width="30%">Hora: </th>
							<td><span id="conf_hora"></span></td>
						</tr>
						<tr>
							<th >Items: </th>
							<td><span id="conf_cant"></span></td>
						</tr>
						<tr>
							<th>Total: </th>
							<td><span id="conf_monto_cd"></span></td>
						</tr>
						<tr>
							<th>Tipo de pago: </th>
							<td><span id="conf_cred"></span></td>
						</tr>
					</table>

    	</div>

    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-light btn red left">Cancelar</a>
      <a href="#!" id="conf_ped" class="waves-effect waves-light btn right">Confirmar pedido</a>
    </div>
  </div>

</div>

</body>
</html>


<script type="text/javascript" src="js/viewpdf.js"></script>
<script>
	let total_img = 0;
	$(document).ready(function(){

		$.ajax({
      url: "recursos/catalogos/files.php",
      method: "GET",
      success: function(response) {
      	total_img = response;
      	document.getElementById("current_page").innerHTML = "1 de "+total_img
      },
      error: function(error) {
          console.log(error)
      }
		})
		$('select').formSelect();
		$('.fixed-action-btn').floatingActionButton({
			hoverEnabled: false,
    	toolbarEnabled: true
  	});
		$('.modal').modal();
  	$('.sidenav').sidenav();
  	$('select').formSelect();
    $('input[type="number"]').niceNumber({
			autoSize: true,
			autoSizeBuffer: 1,
			buttonDecrement: "-",
			buttonIncrement: "+",
			buttonPosition: 'around'
		});

		// $.ajax({  CÓDIGO PARA VISUALIZAR PDF
		//   url: "recursos/catalogos/last-pdf.php",
		//   method: "GET",
		//   success: function(response) {
		//   	response = JSON.parse(response)
		//  		console.log(response.ruta);
		//  		load_pdf(response.ruta);
		//   }
		// })

		$('#search_data').autocomplete({
      source: "recursos/catalogos/search_data.php",
      minLength: 3,
      select: function(event, ui)
      {
        // $("#id_").val(ui.item.id)
        // $("#linea_").val(ui.item.linea)
        // $("#pupesos_").val(parseFloat(ui.item.pupesos).toFixed(1))
        // $("#codli_").val(ui.item.codli)
        if (ui.item.pupesos == null) {
        	$("#__datosprod").html("<input id='__datosp' cp='0' hidden/>")
        	document.getElementById("img_prod").src = "images/fotos_prod/default.png";
        	document.getElementById("cod_prod").innerHTML = "Agotado";
        }else{
        	$("#__datosprod").html("<input id='__datosp' cp='"+ui.item.value+"' np='"+ui.item.id+"' pp='"+ui.item.pupesos+"' fp='"+ui.item.foto+"' st='"+ui.item.cant+"' cl='"+ui.item.codli+"' hidden/>");
        	// $("#img_prod").src(ui.item.foto);
        	document.getElementById("img_prod").src = ui.item.foto;
        	document.getElementById("cod_prod").innerHTML = ui.item.value
        	document.getElementById("div_cantidad").hidden = false;
        	$('#search_data').val(ui.item.value)
        }
        // $('#foto_prod').attr("src", ui.item.foto);
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row fuente'></li>")
        .data("item.autocomplete", item.id)
        .append(item.label)
        .appendTo(ul);
    };

    $('#input_pedido_experta').autocomplete({
      source: "recursos/catalogos/search_experta.php",
      minLength: 3,
      select: function(event, ui)
      {
      		// console.log(ui.item)
        	document.getElementById("input_ca_pedido_experta").value = ui.item.ca;
        	document.getElementById("input_pedido_experta").value = ui.item.value;
        	document.getElementById('input_pedido_experta').disabled = true;
        	M.updateTextFields();
        	// $('#search_data').val(ui.item.value)
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        // console.log(item)
        return $("<li class='ui-autocomplete-row fuente'></li>")
        .data("item.autocomplete", item.id)
        .append(item.label)
        .appendTo(ul);
    };

  });

let pag = 1;
document.getElementById('next').addEventListener('click', () => {
	if (pag >= total_img) {
		return pag = total_img;
	}
	pag += 1;
	let name = "";
	if (pag < 10) {
		name = "images/catalogos/Catalogo_02-2022_2_page-000"+pag+".jpg";
	}
	if (pag >= 10 && pag < 100) {
		name = "images/catalogos/Catalogo_02-2022_2_page-00"+pag+".jpg"
	}
	if (pag > 99) {
		name = "images/catalogos/Catalogo_02-2022_2_page-0"+pag+".jpg"
	}
	document.getElementById("current_page").innerHTML = pag+" de "+total_img
	document.getElementById("img_container").src = name;
})

document.getElementById('previous').addEventListener('click', () => {
	if (pag < 2) {
		return pag = 1;
	}else{
		pag -= 1;
		let name = "";
		if (pag < 10) {
			name = "images/catalogos/Catalogo_02-2022_2_page-000"+pag+".jpg";
		}
		if (pag >= 10 && pag < 100) {
			name = "images/catalogos/Catalogo_02-2022_2_page-00"+pag+".jpg"
		}
		if (pag > 99) {
			name = "images/catalogos/Catalogo_02-2022_2_page-0"+pag+".jpg"
		}
		document.getElementById("current_page").innerHTML = pag+" de "+total_img
		document.getElementById("img_container").src = name;
	}
})

var reg_pedidos = new Array();

document.getElementById('add').addEventListener('click', () => {
	
	var cantp = $("#__cantidad").val();
	var cp = $("#__datosp").attr("cp");
	var np = $("#__datosp").attr("np");
	var pp = $("#__datosp").attr("pp");
	var fp = $("#__datosp").attr("fp");
	var st = $("#__datosp").attr("st");
	var cl = $("#__datosp").attr("cl");
	var pub = $("#__datosp").attr("pp");
	var pup = $("#__datosp").attr("pp");

	$.ajax({
    url: "recursos/catalogos/check_order.php",
    method: "GET",
    success: function(response) {
    	// console.log(response);
    	if (response) {
    		return M.toast({html: 'Usted ya tiene un pedido activo.', displayLength: 2000})
    	}else{
				if (cp == 0) {
					$("#__datosprod").html("<input id='__datosp' cp='1' hidden/>")
					return M.toast({html: "Producto agotado."})
				}
				if (cp == 1) {
					return M.toast({html: "<span style='color:#ffeb3b'>Debe seleccionar un producto.</span>"})
				}
				if (parseInt(cantp) > parseInt(st)) {
					return M.toast({html: "<span style='color:#ffeb3b'>Cantidad insuficiente en stock, "+st+" disponibles.</span>"})
				}

				if (parseInt(cantp) > 50 || cantp == "") {M.toast({html: "El pedido no puede superar las 50 unidades"})}
					else{
				if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."})}
				else{
					


					pp = ((parseFloat(pp)*0.05).toFixed(1))*parseInt(cantp);
					pp = parseFloat(pp.toFixed(1))

					pub = (parseFloat(pub)*0.05).toFixed(1);
					// console.log(pub)
					reg_pedidos[cp] = [cp, np, cantp, pp, fp, pub, pup, cl];


					$("#pedidos_cliente tbody").html("")
					var table = $("#pedidos_cliente tbody")[0];
					let total =  0;
					let in_cant = 0;
					let total_aux = 0;
					let total_ped_cd = 0;
					Object.keys(reg_pedidos).forEach(function(key) {
						var row = table.insertRow(-1);
						row.insertCell(0).innerHTML = `<a style='text-decotarion: none; cursor: pointer; color: red;' onclick='borrar_prod("${key}")'><i class='material-icons prefix'>delete</i></a>`;
						row.insertCell(0).innerHTML = reg_pedidos[key][3];
						row.insertCell(0).innerHTML = reg_pedidos[key][2];
						row.insertCell(0).innerHTML = `<a href='#' onclick='modal_detalle("${key}", "${reg_pedidos[key][1]}", "${reg_pedidos[key][5]}", "${reg_pedidos[key][4]}")'>${key}</a>`;
						total  = parseFloat(total) + parseFloat(reg_pedidos[key][3]);
						in_cant = in_cant + parseInt(reg_pedidos[key][2]);
						if (reg_pedidos[key][7] == '16' || (reg_pedidos[key][7] > 32 && reg_pedidos[key][7] < 38)) {
							total_aux = parseFloat(total_aux) + parseFloat(reg_pedidos[key][3])
						}else{
							total_ped_cd = parseFloat(total_ped_cd) + parseFloat(reg_pedidos[key][3]);
						}
					});
					total_ped_cd = ((parseFloat(total_ped_cd)*(1-parseFloat('<?php echo $_SESSION['desc']; ?>')))+parseFloat(total_aux)).toFixed(1)
					$("#total_ped").html(total +" Bs.");
					$("#total_ped_cd").html(total_ped_cd+" Bs.");
					$("#input_total").val(total);
					$("#input_total_cd").val(total_ped_cd);
					$("#input_cant").val(in_cant);
					// $("#shop_button").addClass('pulse');
					// $("#modal2").modal('close');
				}}

				$("#cart i").html('<img style="max-height: 40px;" src="images/icons/lleno.png"/>');
				M.toast({html: "<span style='color:#1de9b6'>Agregado al carrito de compra.</span>", displayLength: 2500})
				$("#__datosprod").html("<input id='__datosp' cp='1' hidden/>")
				$('#search_data').val("")
			  document.getElementById("img_prod").src = "images/fotos_prod/default.png";
				document.getElementById("cod_prod").innerHTML = "";
				document.getElementById("div_cantidad").hidden = true;
				$('#__cantidad').val(1)
				$("#mod_con").removeClass("disabled")

    	}
    },
    error: function(error) {
        console.log(error)
    }
	})



});

function modal_detalle(cod, producto, pub, foto) {
	document.getElementById("modal_title").innerHTML = producto;
	document.getElementById("modal_foto").src = foto;
	document.getElementById("modal_cod").innerHTML = "<b>Código: </b>"+cod;
	document.getElementById("modal_pu").innerHTML = "<b>Precio U.: </b>"+pub+" Bs.";
	M.Modal.getInstance(modal1).open();

}


document.getElementById('cart').addEventListener('click', () => {
	// console.log("mostrar")
	// M.toast({html: "Agregado al carrito de compras."})
	document.getElementById('cart').hidden = true
	document.getElementById('add_container').hidden = true
	document.getElementById('form_container').hidden = true
	document.getElementById('pdf_container').hidden = true
	document.getElementById('cart_row').hidden = false
	document.getElementById('menu').hidden = true
});

document.getElementById('return').addEventListener('click', () => {
	// console.log("ocultar")
	// M.toast({html: "Agregado al carrito de compras."})
	document.getElementById('cart').hidden = false
	document.getElementById('add_container').hidden = false
	document.getElementById('form_container').hidden = false
	document.getElementById('pdf_container').hidden = false
	document.getElementById('cart_row').hidden = true
	document.getElementById('menu').hidden = false
});

	function borrar_prod(x) {
		// console.log(x)
		// console.log(reg_pedidos[x]+"<<<antes")
		delete reg_pedidos[x];
		// console.log(reg_pedidos['AX00229']+"<<<despues")
		// console.log(reg_pedidos)
				//borrando tabla
			// $('#pedidos_cliente tr:not(:first-child)').slice(0).remove();
			// var table = $("#pedidos_cliente")[0];
			$("#pedidos_cliente tbody").html("") //limpiar tabla
			var table = $("#pedidos_cliente tbody")[0]; //obtener tabla
			
			let total =  0;
			let total_ped_cd = 0;
			let total_aux = 0;
			let in_cant = 0;
			//llenando tabla
			// console.log(reg_pedidos.length, "tamaño del array reg pedidos") // REVISANDO EL ARRAY
			// var json_ped = JSON.parse(JSON.stringify(reg_pedidos))
			// console.log(json_ped)
			Object.keys(reg_pedidos).forEach(function(key) {
				console.log(reg_pedidos[key]+"<dentro del foreach")
				var row = table.insertRow(-1);
				row.insertCell(0).innerHTML = `<a style='text-decotarion: none; cursor: pointer; color: red;' onclick='borrar_prod("${key}")'><i class='material-icons prefix'>delete</i></a>`;
				row.insertCell(0).innerHTML = reg_pedidos[key][3];
				row.insertCell(0).innerHTML = reg_pedidos[key][2];
				row.insertCell(0).innerHTML = "<a href='#'>"+reg_pedidos[key][0]+"</a> ";
				total  = parseFloat(total) + parseFloat(reg_pedidos[key][3]);
				in_cant = in_cant + parseInt(reg_pedidos[key][2]);
				if (reg_pedidos[key][7] == '16' || (reg_pedidos[key][7] > 32 && reg_pedidos[key][7] < 38)) {
					total_aux = parseFloat(total_aux) + parseFloat(reg_pedidos[key][3])
				}else{
					total_ped_cd = parseFloat(total_ped_cd) + parseFloat(reg_pedidos[key][3]);
				}
			});
			total_ped_cd = ((parseFloat(total_ped_cd)*(1-parseFloat('<?php echo $_SESSION['desc']; ?>')))+parseFloat(total_aux)).toFixed(1)
			$("#total_ped").html(total +" Bs.");
			$("#total_ped_cd").html(total_ped_cd+" Bs.")
			$("#input_total").val(total);
			$("#input_total_cd").val(total_ped_cd);
			$("#input_cant").val(in_cant);
			// console.log(Object.keys(reg_pedidos).filter(Boolean))
			if ((Object.keys(reg_pedidos).filter(Boolean)).length < 1) {
				$("#cart i").html('<img style="max-height: 40px;" src="images/icons/vacio.png"/>');
				$("#mod_con").addClass("disabled")
			}
	}

	document.getElementById('mod_con').addEventListener('click', () => {
		const MESES = [
		  "Enero",
		  "Febrero",
		  "Marzo",
		  "Abril",
		  "Mayo",
		  "Junio",
		  "Julio",
		  "Agosto",
		  "Septiembre",
		  "Octubre",
		  "Noviembre",
		  "Diciembre",
		];
		let today = new Date();
		let date = today.getDate()+' de '+MESES[today.getMonth()]+' del '+today.getFullYear()
		let hour = today.getHours() + ":" + today.getMinutes();
		let cred
		if (document.getElementById('pago').checked) {
			cred = "Crédito"
		}else{
			cred = "Contado"
		}

		document.getElementById("conf_fecha").innerHTML = `${date}`
		document.getElementById("conf_hora").innerHTML = `${hour}`
		document.getElementById("conf_cant").innerHTML = `${document.getElementById('input_cant').value}`
		// document.getElementById("conf_monto").innerHTML = `<b>Subtotal: </b>${document.getElementById('input_total').value} Bs.`
		document.getElementById("conf_monto_cd").innerHTML = `${document.getElementById('input_total_cd').value} Bs.`
		document.getElementById("conf_cred").innerHTML = `${cred}`

		$("#modal2").modal('open')

	});

	document.getElementById('conf_ped').addEventListener("click", () => {

		let ca_exp = document.getElementById('input_ca_pedido_experta').value;
		let nombres_experta = document.getElementById('input_pedido_experta').value;

		if((document.getElementById('check_pedido_experta').checked) && (ca_exp.length < 1)){
			return M.toast({html: 'Debe ingresar los datos de la experta.'});
		}


		if (ca_exp.length < 1) {
			ca_exp  = "";
		}else{
			ca_exp = "&ca_exp="+ca_exp;
		}

		let total = document.getElementById('input_total').value;
		let total_cd = document.getElementById('input_total_cd').value;
		let credito = document.getElementById('pago').checked;
		// let json_detalle = reg_pedidos.filter(Boolean)
		// json_detalle = JSON.stringify(json_detalle)

				// reg_pedidos[cp] = [cp, np, cantp, pp, fp, pub, pup, codli];
		// console.log(reg_pedidos + "<<<----")
		// let x = "";
		let cant_items = 0;
		let a = new Array()
		Object.keys(reg_pedidos).forEach(function(key) {
			// console.log(reg_pedidos[key][7] +"<<< linea ")
			// x = x+`{${key}:[{${reg_pedidos[key][1]},${reg_pedidos[key][2]},${reg_pedidos[key][3]},${reg_pedidos[key][5]},${reg_pedidos[key][6]}}]}`;
			a.push([reg_pedidos[key][0], reg_pedidos[key][1], reg_pedidos[key][2], reg_pedidos[key][3], reg_pedidos[key][5], reg_pedidos[key][6], reg_pedidos[key][7]]);
			cant_items += parseInt(reg_pedidos[key][2]);
		})
		

		x = JSON.stringify(a)
		// x = JSON.parse(a)
		// return console.log(a.length)
		let cliente = "";
		if (nombres_experta.length < 1) {
			cliente = "```<?php echo $_SESSION['usuario'].' '.$_SESSION['apellidos']?>```";
		}else{
			cliente = "```"+nombres_experta+"```";
		}
		// console.log(a[0][0]+" <<< X")
		let detalle = "";
		a.forEach(function(x) {
			// console.log(x[0])
			detalle = detalle+'*'+x[0]+'* ```'+x[1]+'``` *x'+x[2]+'*%0A';
			// *${x[0]}*-${x[1]} *x${x[2]}*%0A
		})
		let tipo = "";
		if (credito) {
			tipo = "Crédito";
		}else{
			tipo = "Contado";
		}

		if(a.length > 0){
		    $.ajax({
	            url: "recursos/catalogos/nuevo_pedido.php?total="+total+"&total_cd="+total_cd+"&a="+x+"&cred="+credito+ca_exp,
	            method: "GET",
	            success: function(response) {
	            	// console.log(response+"<<<< respuesta de php")
	              if (response == 1) {
	                M.toast({html:'<span style="color: #2ecc71">Pedido realizado, puedes ver tu pedido en la sección de Mi pedido</span>', displayLength: 5000, classes: 'rounded'})
	                	$("#modal2").modal('close')
	                	clean_table();
	                	let texto = `*LIDER/EXPERTA:*%0A${cliente}%0A*DETALLE DEL PEDIDO:*%0A${detalle}*Monto a pagar:* ${total_cd} Bs.%0A*Cant. Items:* ${cant_items}%0A*Tipo de pago:* ${tipo}`;
	                							// *Catálogo Arbell:* Crema facial
	                	window.location.href = "https://wa.me/59175174075?text="+texto;
	                	// 76191403
	              }
	              if (response == 2) {
	              	M.toast({html: '<span style="color: #f6e58d">Usted ya tiene un pedido pendiente.</span>'})
	              }
	            },
	            error: function(error) {
	                console.log(error)
	            }
		    })
		}else{
			M.toast({html: "No se ha seleccionado ningún producto..."});
		}
	})

	document.getElementById("check_pedido_experta").addEventListener('change', () => {
		let check = document.getElementById("check_pedido_experta").checked;
		if (check) {
			document.getElementById('input_pedido_experta').disabled = false;
			document.getElementById('input_pedido_experta').value = "";
			document.getElementById('input_ca_pedido_experta').value = "";
			document.getElementById('pedido_experta_container').hidden = false;
		}else{
			document.getElementById('input_pedido_experta').disabled = false;
			document.getElementById('input_pedido_experta').value = "";
			document.getElementById('input_ca_pedido_experta').value = "";
			document.getElementById('pedido_experta_container').hidden = true;
		}
	})

	document.getElementById('a_eliminar_experta').addEventListener('click', () => {
		document.getElementById('input_pedido_experta').disabled = false;
		document.getElementById('input_pedido_experta').value = "";
		document.getElementById('input_ca_pedido_experta').value = "";
	})

	function clean_table() {
		reg_pedidos = [];
		$("#pedidos_cliente tbody").html("<td colspan=4 class='center'>No se ha seleccionado ningún producto.</td>") //limpiar tabla
		$("#total_ped").html("0 Bs.");
		$("#total_ped_cd").html("0 Bs.")
		document.getElementById('pago').checked = false
		if ((reg_pedidos.filter(Boolean)).length < 1) {
			$("#cart i").html('<img style="max-height: 40px;" src="images/icons/vacio.png"/>');
			$("#mod_con").addClass("disabled")
		}
	}

	function _load (url) {
		let y = '.php';
		document.getElementById('cart').hidden = true;
		if (screen.width < 993) {
			$(".sidenav").sidenav('close')
		}
		$("#cuerpo").load(url+y);
	}

</script>
