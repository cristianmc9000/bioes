<?php 
	require('../../recursos/conexion.php');
	session_start();
	$ca=$_SESSION["ca"];
	date_default_timezone_set("America/La_Paz");
	$year = ""; 

	$res = $conexion->query("SELECT * FROM `clientes` WHERE estado = 1 AND lider = ".$ca);
	$result = $res->fetch_all(MYSQLI_ASSOC);

    $texto = "";
	if (mysqli_num_rows($res) < 1) {
        $texto = 'No tienes ninguna experta bajo tu cargo.';
		// echo var_dump($result[0]['CA']);
	}
	

?>
<style>
.card__img {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.horizontal{
    /*display: grid !important;*/
    /*grid-template-columns: 1fr 1fr;*/
    /*gap: 5px;*/
}
</style>
<br>
<div class="container">
    <div class="row">
        <div class="input-field col s12 m6 offset-m3">
            <i class="material-icons prefix">search</i> 
            <input type="text" id="buscar_experta">
            <label for="buscar_experta">Buscar experta...</label>
        </div>
    </div>
    <div class="row" id="cards_body">
        <span><?php echo $texto ?></span>
        <?php foreach($result as $key  => $valor){ ?>
        <div class="col s12 m6 roboto">
            <div class="z-depth-4 card horizontal card__pad" style="background-color: #ede7f6; border-radius: 3px; border-color: #d1c4e9; border-style: solid;">
                <div class="card-stacked">
                        <div><span><b>Nombre: </b><small><?php echo $valor['nombre'].' '.$valor['apellidos']?></small></span></div>
                        <div><span><b>Celular: </b><?php echo $valor['telefono']?></span></div>
                        <div><span><b>CA: </b><?php echo $valor['CA']?></span></div>
                        <div><span><b>CI: </b><?php echo $valor['CI']?></span></div>
                </div>
                <div class="card__img" style="margin-left: 5px;">
                    <div>
                        <a onclick="historial('<?php echo $valor['CA'] ?>')" style="float: right"
                            class="btn-small waves-effect waves-light white black-text">Historial</a>
                    </div>
                    <div>
                        <a onclick="bloquear('<?php echo $valor['CA'] ?>', event)" style="float: right"
                            class="btn-small waves-effect waves-light red lighten-1 "><?php if($valor['block'] == '1'){echo 'Bloquear';}else{echo 'Desbloquear';}?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.modal').modal();
    $("#titulo").html('Mis expertas');
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };
    document.querySelectorAll('.dd').forEach(function(e) {
        fecha = new Date(e.innerText);
        e.innerText = fecha.toLocaleDateString("es-ES", options);;
    });
});

document.getElementById('buscar_experta').addEventListener('input', () =>{
    var filtro = document.getElementById('buscar_experta').value;
    if (filtro.length > 0 && filtro.length < 3) {
        return false;
    }

    let key = document.getElementById('buscar_experta').value;
    let cards_body = document.getElementById('cards_body');
    fetch('recursos/catalogos/filtro_expertas.php?key='+key)
    .then(response => {
        response.json().then(function(res) {  
            let cad = "";
            let block = '';
            res.forEach(function(item, index, arr){

                if (item['block'] == '1') {
                    block = 'Bloquear'
                }else{
                    block = 'Desbloquear'
                }

                cad = cad + `<div class="col s12 m6 l6 xl6 roboto">
                                <div class="z-depth-4 card horizontal card__pad" style="background-color: #eee5e9; border-radius: 20px; border-color: #ccc3c7; border-style: solid;">
                                    <div class="card-stacked">
                                        <div class="" >
                                            <span><b>Nombre: </b><small>${item['nombre']+" "+item['apellidos']}</small></span><br>
                                            <span><b>Celular: </b>${item['telefono']}</span><br>
                                            <span><b>CA: </b>${item['CA']}</span><br>
                                            <span><b>CI: </b>${item['CI']}</span>
                                        </div>
                                    </div>
                                    <div class="card__img" style="margin-left:5px;">
                                        <div>
                                            <a onclick="historial('${item['CA']}')" style="float: right"
                                                class="btn-small waves-effect waves-light">Historial</a>
                                        </div>
                                        <div>
                                            <a onclick="bloquear('${item['CA']}', event)" style="float: right"
                                                class="btn-small waves-effect waves-light red lighten-2 ">${block}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            })                
            cards_body.innerHTML = cad;
        })
    })
})
function historial(ca) {
    $("#cuerpo").load("templates/catalogos/historial.php?ca="+ca);
}
function bloquear(ca, e) {
    fetch('recursos/catalogos/block.php?ca='+ca)
    .then(response => response.text())
    .then(data => {
        if (data.includes('1')) {
            e.target.innerHTML = 'Bloquear'
        }else{
            e.target.innerHTML = 'Desbloquear'
        }
    })
}

document.getElementById("back_expertas").addEventListener('click', ()=> {
    document.getElementById('menu').hidden = false;
    document.getElementById('back_expertas').hidden = true;
})

</script>