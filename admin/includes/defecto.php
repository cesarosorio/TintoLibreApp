<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de Opciones</li>
</ol>

<?php if ($Permiso != 5) { ?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Lista de opciones de lider</li>
</ol>

<div class="card-deck">
  
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Crear una nueva semilla</h5>
      <p class="card-text"><a href="?contenido=newsemilla" class="btn btn-dark btn-block">Ir al módulo</a></p>
    </div>
  </div>

  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Ver alertas</h5>
      <p class="card-text"><a href="?contenido=ver_alerta" class="btn btn-dark btn-block">Ir al módulo</a></p>
    </div>
  </div>   
 </div>
 <br>
 <div class="card-deck">
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">INFORMACIÓN DE MIS SEMILLAS</h5>
      <p class="card-text"><a href="?contenido=viewSemilla" class="btn btn-dark btn-block">Ir al módulo</a></p>
    </div>
  </div>  

    <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Ver solicitudes de préstamos</h5>
      <p class="card-text"><a href="?contenido=viewprest" class="btn btn-dark btn-block">Ir al módulo</a></p>
    </div>
  </div>

</div>

<br>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Opciones generales</li>
</ol>


<?php } ?>

<div class="d-flex flex-row w-100 p-per-2 justify-content-between">
  <div id="pse-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
      <div class="d-flex w-100 icono-opciones pse-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Consignación en línea</p></div>
    </div>
  </div>
  <div id="registrar-ahorro-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
    <div class="d-flex w-100 icono-opciones registrar-ahorro-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Registra tu ahorro</p></div>
    </div>
  </div>
  <div id="crecimiento-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
    <div class="d-flex w-100 icono-opciones crecimiento-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Crecimiento TuSemilla</p></div>
    </div>
  </div>
</div>

<div class="d-flex flex-row w-100 p-per-2 justify-content-between">
  <div id="pse-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
      <div class="d-flex w-100 icono-opciones pse-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Consignación en línea</p></div>
    </div>
  </div>
  <div id="pedir-prestamo-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
    <div class="d-flex w-100 icono-opciones registrar-ahorro-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Pedir préstamo TuSemilla</p></div>
    </div>
  </div>
  <div id="crecimiento-button" class="d-flex w-per-30 justify-content-center align-center flex-column cursor-pointer">
    <div class="d-flex w-100 flex-column contenedor-opcion">
    <div class="d-flex w-100 icono-opciones crecimiento-icono">&nbsp;</div>
      <div class="d-flex w-100"><p class="text-center w-100 texto-icono">Crecimiento TuSemilla</p></div>
    </div>
  </div>
</div>
<!-- <div class="card-deck">
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Ver cuánto hemos ahorrado</h5>
      <p class="card-text"><a href="?contenido=dwcomprobante" class="btn btn-dark btn-block">Presiona aquí</a></p>
    </div>
  </div>
 
</div>

<br> 

<div class="card-deck">
  
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Recuerda las reglas de juego de tus semillas</h5>
      <p class="card-text"><a href="?contenido=verpsemillas" class="btn btn-dark btn-block">Presiona aquí</a></p>
    </div>
  </div>
 <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Solicitar un préstamo</h5>
        <input type='button' name='view' value='Quiero solicitar un préstamo' id='<?php echo $User ?>' class='btn btn-dark btn-block view_data'/> 
    </div>
  </div>
 
</div> -->

<br> 

<div class="card-deck">
  
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Ver préstamos</h5>
      <p class="card-text"><a href="?contenido=menus_prestamos" class="btn btn-dark btn-block">Presiona aquí</a></p>
    </div>
  </div>
 <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Votar</h5>
      <p class="card-text"><a href="?contenido=votaciones" class="btn btn-dark btn-block">Presiona aquí</a></p>
    </div>
  </div>
 
</div>

<br> 
 
<br>
<div class="alert alert-secondary" role="alert">
    INFORMACIÓN PARA CONSIGNACIÓN: Cuenta de ahorros Banco Caja Social No. 241 1557 1664 A nombre de TintoLibre Nit: 901.563.012-2
</div>


<script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '#pedir-prestamo-button', function(){  
          var employee_id = '<?php echo $User ?>';
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/CrearPrestamo.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                      debugger;
                          $('#employee_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
      });
      $(document).on('click', '#pse-button', function(){  
        window.open("https://www.mipagoamigo.com/MPA_WebSite/ServicePayments/StartPayment?id=8851&searchedCategoryId=&searchedAgreementName=TINTOLIBRE",  '_blank');         
      }); 
      $(document).on('click', '#registrar-ahorro-button', function(){  
        window.location = "?contenido=upcomprobante";         
      }); 
      $(document).on('click', '#crecimiento-button', function(){  
        window.location = "?contenido=dwcomprobante";         
      });  
 });  
 </script>
 <div id="dataModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Por favor, llene los datos a continuación</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>