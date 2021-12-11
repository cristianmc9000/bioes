<?php 
  date_default_timezone_set("America/La_Paz");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de ventas</title>
<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }

  /*.fijo{
    border-style: solid;
    border-color: red;
  }*/
  .auto-imagen{
    padding:  1px;
    border: 4px solid transparent;
    background: linear-gradient(60deg, #afafaf 10%, #4e4e4e 100%);
    width: 80%;
    height:  250px;
  }
  .vert{
    /*vertical-align: center;*/
/*    position: relative;
    top: 100%;*/
    padding-top: 150px;
  }

  </style>
</head>
<body>

<div class="container vert">
  <div class="row">
    <div class="col-sm-8 offset-sm-2">

      <!-- <div class="input-group mb-3"> -->
        <label for="tipo_reporte">Seleccione el tipo de reporte:</label>
        <div class="input-group mb-3 col-sm-12">
          <select class="form-select" name="tipo_reporte" id="tipo_reporte" aria-label="Default select example">
              <option value="r_ventas.php" selected><b>Reportes de ventas</b></option>
              <option value="r_compras.php"><b>Reporte de compras</b></option>
              <option value="r_le.php"><b>Reporte de clientes</b></option>
          </select>
        </div>

        <label for="gestion"><b>Seleccione la gestión</b></label>
        <div class="input-group mb-3 col-sm-12">
                  <select class="form-select" aria-label="Default select example" name="gestion" id="gestion">
                    <option value="2021"  '<?php if(date("Y") == "2021"){echo "selected";} ?>'><b>2021</b></option>
                    <option value="2022"  '<?php if(date("Y") == "2022"){echo "selected";} ?>'><b>2022</b></option>
                    <option value="2023"  '<?php if(date("Y") == "2023"){echo "selected";} ?>'><b>2023</b></option>
                    <option value="2024"  '<?php if(date("Y") == "2024"){echo "selected";} ?>'><b>2024</b></option>
                    <option value="2025"  '<?php if(date("Y") == "2025"){echo "selected";} ?>'><b>2025</b></option>
                  </select> 
        </div>

        <label for="mes"><b>Seleccione el mes</b></label>
        <div class="input-group mb-3 col-sm-12">
                <select class="form-select" aria-label="Default select example" name="mes" id="mes">
                  <option value="0" selected>Reporte anual</option>
                  <option value="01"><b>Enero</b></option>
                  <option value="02"><b>Febrero</b></option>
                  <option value="03"><b>Marzo</b></option>
                  <option value="04"><b>Abril</b></option>
                  <option value="05"><b>Mayo</b></option>
                  <option value="06"><b>Junio</b></option>
                  <option value="07"><b>Julio</b></option>
                  <option value="08"><b>Agosto</b></option>
                  <option value="09"><b>Septiembre</b></option>
                  <option value="10"><b>Octubre</b></option>
                  <option value="11"><b>Noviembre</b></option>
                  <option value="12"><b>Diciembre</b></option>
                </select>
        </div>

        <div class="input-group mb-3 col-sm-12">
          <!-- <a href="#" onclick="reporte_mes()" class="btn-large blue">Reporte por mes</a> -->
          <a href="#" onclick="reporte_ges()" class="btn btn-primary">Generar reporte</a>
        </div>
      <!-- </div> -->
    </div>
  </div>
</div>


<!--MODAL PARA RECIBIR MENSAJES DESDE PHP-->  
<div class="row">
  <div id="modal2" class="modal col s4 offset-s4">
    <div id="mensaje" class="modal-content">

    </div>
    <div class="modal-footer row">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>
</div>



<script>

var mensaje = $("#mensaje");
mensaje.hide();


  $(document).ready(function() {

  });

//reporte por periodo y gestión
function reporte(periodo) {
   gestion = document.getElementById('gestion').value
   tipo = document.getElementById('tipo_reporte').value
   console.log("templates/reportes/"+tipo+"?ges="+gestion+"&per="+periodo)
   $("#cuerpo").load("templates/reportes/"+tipo+"?ges="+gestion+"&per="+periodo)
}
//reporte anual
function reporte_ges(){
  let per = $("#mes").val()
  gestion = document.getElementById('gestion').value
  tipo = document.getElementById('tipo_reporte').value

  // console.log(per, gestion, tipo)
  $("#cuerpo").load("templates/reportes/"+tipo+"?ges="+gestion+"&per="+per)
}

</script>
</body>
</html>