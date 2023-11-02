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

<div class="card-deck">
  
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Registrar mi ahorro</h5>
      <p class="card-text"><a href="?contenido=upcomprobante" class="btn btn-dark btn-block">Presiona aquí</a></p>
    </div>
  </div>

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
 
</div>

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

<a target="_blank" style="text-decoration: none;" href="https://www.mipagoamigo.com/MPA_WebSite/ServicePayments/StartPayment?id=8851&searchedCategoryId=&searchedAgreementName=TINTOLIBRE">
<div class="alert alert-primary" role="alert" align="center">
    MI BANCO AMIGO
</div>
</a> 


<script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/CrearPrestamo.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail').html(data);  
                          $('#dataModal').modal('show');  
                     }  
                });  
           }            
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