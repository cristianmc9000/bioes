<?php 
	session_start();
	require('../../recursos/conexion.php');
	$salir = '<a href="recursos/salir.php" class="right" target="_self"><i class="material-icons">logout</i>Cerrar sesión</a>';

	// SELECT codp, SUM(cantidad) as cant FROM `detalle_venta` WHERE 1 GROUP BY codp ORDER BY cant DESC
	if (isset($_GET['pageno'])) {
		$pageno = $_GET['pageno'];
	}else{
		$pageno = 1;
	}

	// $pag_elems = 10;
	$indice = ($pageno -1)*10;


	$total_pages_sql = "SELECT COUNT(*) FROM productos WHERE estado = 1";
	$result_pages = mysqli_query($conexion,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result_pages)[0];
	$total_pages = ceil($total_rows / 10);

	$result = $conexion->query("SELECT a.id, a.linea, a.descripcion, a.foto, (SELECT d.pupesos FROM inventario d WHERE d.id = (SELECT MAX(e.id) FROM inventario e WHERE e.codp = a.id AND e.estado = 1) AND d.estado = 1 AND d.codp = a.id) AS pupesos, b.nombre, f.cantidad FROM productos a, invcant f, lineas b WHERE a.estado = 1 AND a.checkbox = 1 AND a.linea = b.codli AND a.id = f.codp ORDER BY id ASC LIMIT ".$indice.", 10");
	$res = $result->fetch_all(MYSQLI_ASSOC);

	$result2 = $conexion->query("SELECT valor FROM cambio WHERE id = 2");
	$res2 = $result2->fetch_all(MYSQLI_ASSOC);

?>

	<div id="form__">
		<div class="row">
			<div class="input-field col s12 m6 offset-m3" id="form_container">
						<i class="material-icons prefix">search</i>
						<input id="search_promos" type="text" autocomplete="off" class="validate semi">
						<label for="search_promos">Buscar producto...</label>
					<div id="__datosprod" hidden><input id='__datosp' cp='1'/></div>
			</div>
		</div>
		<div class="col s12" id="cards_body">
      
      <?php foreach($res as $key  => $valor){ ?>
      <div class="col s12 m6 rubik" loading="lazy" onclick="cantidad_prod('<?php echo $valor['id'] ?>','<?php echo $valor['descripcion'] ?>','<?php echo $valor['pupesos'] ?>','<?php echo $valor['foto'] ?>', '<?php echo $valor['cantidad'] ?>', '<?php echo $valor['linea'] ?>')">
          <div class="z-depth-3 card horizontal p_card__pad" style="background-color: #eee5e9; border-radius: 20px">
              <div class="card-stacked">
                  <div class="" >
                      <span><p style="line-height: 0 "><b><?php echo $valor['id'] ?></b></p></span>
                      <span><small><p style="line-height: 1 "><?php echo $valor['descripcion']?></p></small></span><br>
                      <span style="position: absolute; bottom: 0px;"><b><?php echo round($valor['pupesos']*$res2[0]['valor'], 1)." Bs."?></b></span>
                  </div>
              </div>
              <div class="p_card__img">
                  <img loading="lazy" class="p_img__card" src="<?php echo $valor['foto'] ?>">
              </div>
          </div>
      </div>
      <?php } ?>

    </div>
	</div>
	<br>
<!-- 	<div id="div_paginador" class="center">
		<ul class="pagination">
		    <li><a href="?pageno=1">Inicio</a></li>
		    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
		        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><i class="material-icons">arrow_back</i></a>
		    </li>
		    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
		        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><i class="material-icons">arrow_forward</i></a>
		    </li>
		    <li><a href="?pageno=<?php echo $total_pages; ?>">Final</a></li>
		</ul>
	</div> -->


	<div id="modal3" class="modal fuente modal_prod">

    <div class="modal-content" id="modal3-content" style="padding-top: 3px; padding-bottom: 0px;">
    	<div class="row">
	      <div class="center col s12">
	      	<!-- <h6 id="modal_title"  style=" font-weight: bold;"></h6> -->
	      	<div id="cant_contenedor_foto" style="margin: auto">
	      		<img id="cant_foto" src="images/fotos_prod/default.png" width="100%" alt="">
	      	</div>
	      </div>
      </div>
      <div class="row div_cantidad_">
	      <div style="line-height: 1" class="col s7">
	      	<h6>
	      		<b><p id="cant_cod"></p></b>
	      		<small><b><p id="cant_desc"></p></b></small>
	      		<b><p id="cant_precio"></p></b>
	      	</h6>
	    	</div>
	    	<div class="col s4 offset-s1" id="div_cantidad">
						<div class="number-container">
							<input class="browser-default" type="number" name="" id="__cantidad" min="1" max="100" disabled>
						</div>
	    	</div>
    	</div>
    </div>

    <div class="modal-footer">
    	<a href="#!" class="modal-close rubik waves-effect red waves-light btn left">Cancelar</a>
      <a href="#!" class="rubik waves-effect waves-light btn right" id="add"><i class="material-icons right">add_shopping_cart</i>Agregar</a>
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


<script>
	// let total_img = 0;
	$(document).ready(function(){
		$("#titulo").html('Promociones');
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
      }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $("<li class='ui-autocomplete-row fuente'></li>")
        .data("item.autocomplete", item.id)
        .append(item.label)
        .appendTo(ul);
    };
  });

document.getElementById('search_promos').addEventListener('input', () =>{
    let key = document.getElementById('search_promos').value;
    if (key.length < 3 && key.length > 0) {
    	return false;
    }
    let cards_body = document.getElementById('cards_body');
    fetch('recursos/catalogos/search_promos.php?term='+key)
    .then(response => {
        response.json().then(function(res) { 
        		let cad = ""; 
        		if (res.value === "") {
        			cad = "No se encontraron coincidencas."
        		}else{
	            res.forEach(function(item, index, arr){
					      cad = cad + `<div class="col s12 m6 rubik" loading="lazy" onclick="cantidad_prod('${item.value}','${item.id}','${item.pupesos}','${item.foto}', '${item.cant}', '${item.codli}')">
									          <div class="z-depth-3 card horizontal p_card__pad" style="background-color: #eee5e9; border-radius: 20px">
									              <div class="card-stacked">
									                  <div class="" >
									                      <span><p style="line-height: 0 "><b>${item.value}</b></p></span>
									                      <span><small><p style="line-height: 1 ">${item.id}</p></small></span><br>
									                      <span style="position: absolute; bottom: 0px;">${(item.pupesos*parseFloat("<?php echo $res2[0]['valor']; ?>")).toFixed(1)} Bs.</b></span>
									                  </div>
									              </div>
									              <div class="p_card__img">
									                  <img loading="lazy" class="p_img__card" src="${item.foto}">
									              </div>
									          </div>
							      		</div>`
	            })
	          }              
            cards_body.innerHTML = cad;
        })
    })
})

function cantidad_prod(id, descripcion, precio, foto, stock, codli) {

	let instance = M.Modal.getInstance(document.getElementById('modal3'))
	let cambio = `<?php echo $res2[0]['valor'] ?>`
	let precio_bs = (precio*parseFloat(cambio)).toFixed(1);
	document.getElementById("cant_foto").src = foto;
	document.getElementById("cant_cod").innerHTML = id;
	document.getElementById("cant_desc").innerHTML = descripcion;
	document.getElementById("cant_precio").innerHTML = precio_bs+" Bs.";

	document.getElementById('__datosprod').innerHTML = "<input id='__datosp' cp='"+id+"' np='"+descripcion+"' pp='"+precio+"' fp='"+foto+"' st='"+stock+"' cl='"+codli+"'/>";

	fetch('recursos/catalogos/checkbox.php?id='+id)
	.then(response => response.text())
	.then(data => {
		if (data == '2') {
			return M.toast({html: '<b>Producto retirado del catalogo</b>', displayLength: 3000})
		}
		instance.open();
	});
	
}

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

	// console.log(cp)

	$.ajax({
    url: "recursos/catalogos/check_order.php",
    method: "GET",
    success: function(response) {
    	// console.log(response);
    	if (response) {
    		return M.toast({html: 'Usted ya tiene un pedido activo.', displayLength: 2000})
    	}else{
				if (cp === 0) {
					$("#__datosprod").html("<input id='__datosp' cp='1' hidden/>")
					return M.toast({html: "Producto agotado."})
				}
				if (cp === 1) {
					return M.toast({html: "<span style='color:#ffeb3b'>Debe seleccionar un producto.</span>"})
				}
				if (parseInt(cantp) > parseInt(st)) {
					return M.toast({html: "<span style='color:#ffeb3b'>Cantidad insuficiente en stock, "+st+" disponibles.</span>"})
				}

				if (parseInt(cantp) > 50 || cantp == "") {M.toast({html: "El pedido no puede superar las 50 unidades"})}
					else{
				if (parseInt(cantp) < 1 || cantp == "") { M.toast({html: "Ingresa una cantidad válida."})}
				else{
					

					let _cambio = parseFloat(`<?php echo $res2[0]['valor'] ?>`);
					pp = ((parseFloat(pp)*_cambio).toFixed(1))*parseInt(cantp);
					pp = parseFloat(pp.toFixed(1))

					pub = (parseFloat(pub)*_cambio).toFixed(1);
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
				M.toast({html: "<span style='color:#1de9b6'><b>Agregado al carrito de compra.</b></span>", displayLength: 2500})
				$("#__datosprod").html("<input id='__datosp' cp='1' hidden/>")
				$('#search_promos').val("")
			  // document.getElementById("img_prod").src = "images/fotos_prod/default.png";
				// document.getElementById("cod_prod").innerHTML = "";
				// document.getElementById("div_cantidad").hidden = true;
				$('#__cantidad').val(1)
				$("#mod_con").removeClass("disabled")
				$("#modal3").modal('close');
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
	// document.getElementById('div_paginador').hidden = true;
	document.getElementById('cart').hidden = true
	document.getElementById('form__').hidden = true
	document.getElementById('cart_row').hidden = false
	document.getElementById('menu').hidden = true
});

document.getElementById('return').addEventListener('click', () => {
	// document.getElementById('div_paginador').hidden = false;
	document.getElementById('cart').hidden = false
	document.getElementById('form__').hidden = false
	document.getElementById('cart_row').hidden = true
	document.getElementById('menu').hidden = false
});

	function borrar_prod(x) {
		delete reg_pedidos[x];
			$("#pedidos_cliente tbody").html("") //limpiar tabla
			var table = $("#pedidos_cliente tbody")[0]; //obtener tabla
		
			let total =  0;
			let total_ped_cd = 0;
			let total_aux = 0;
			let in_cant = 0;

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

		let cant_items = 0;
		let a = new Array()
		Object.keys(reg_pedidos).forEach(function(key) {
			a.push([reg_pedidos[key][0], reg_pedidos[key][1], reg_pedidos[key][2], reg_pedidos[key][3], reg_pedidos[key][5], reg_pedidos[key][6], reg_pedidos[key][7]]);
			cant_items += parseInt(reg_pedidos[key][2]);
		})
		

		x = JSON.stringify(a)

		let cliente = "";
		if (nombres_experta.length < 1) {
			cliente = "```<?php echo $_SESSION['usuario'].' '.$_SESSION['apellidos']?>```";
		}else{
			cliente = "```"+nombres_experta+"```";
		}

		let detalle = "";
		a.forEach(function(x) {
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
	                M.toast({html:'<span style="color: #2ecc71"><b>Pedido realizado, puedes ver tu pedido en la sección de Mi pedido</b></span>', displayLength: 5000, classes: 'rounded'})
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



</script>