<!-- FALTA BORRAR LINEAS, MODIFICAR LINEAS-->
<!-- ELIMINAR VENTAS -->

<style>

  .fuente{
    font-family: 'Segoe UI light';
    color: red;
  }

.fijo{
/*  max-width: 250px;
  border-radius: 50%
  width: 250px !important;
  height: 100px !important;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;*/

  /*height: 350px;
  border-radius: 50%;
  background : #ffffff;*/
}
.auto-imagen{
  padding:  1px;
  border: 4px solid transparent;
  background: linear-gradient(60deg, #afafaf 10%, #4e4e4e 100%);
  width: 80%;
  height:  250px;
}

  </style>


<span class="fuente"><h3>Seleccionar Periodo</h3></span>

<form action="recursos/redireccionador.php" method="post" class="col s12" id="ffecha">
    <input type="text" name="mes" id="mes" value="" hidden>
  <br><br>
<!-- <button class="btn waves-effect waves-light" type="submit">Aceptar</button> -->
</form>
<div class="row center">

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('01');" >

      <img class="z-depth-5 auto-imagen" src="img/periodos/1.png" >

  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('02');" >

      <img class="z-depth-5 auto-imagen" src="img/periodos/2.png" >

  </a>
</div>


<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('03');" >

      <img class="z-depth-5 auto-imagen" src="img/periodos/3.png" >

  </a>
</div>
</div>
<div class="row center">

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('04');" >


      <img class="z-depth-5 auto-imagen" src="img/periodos/4.png" >


  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('05');" >

      <img class="z-depth-5 auto-imagen" src="img/periodos/5.png" >
    
  
  </a>
</div>

<div class="fijo col s4" >
  <a href="#" onclick="enviarfecha('06');" >

      <img class="z-depth-5 auto-imagen" src="img/periodos/6.png" >

  </a>
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
    // $('select').material_select();
  });


function enviarfecha(mes_recibido) {
   
  /*  anio = document.getElementById('anio').value; */
   document.getElementById('mes').value = mes_recibido;
   mes = mes_recibido;
   
   $("#cuerpo").load("templates/productos/productos.php?mes="+mes);

   
}

</script>





