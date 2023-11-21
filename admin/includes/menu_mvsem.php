<ol class="breadcrumb"> 
    <li class="breadcrumb-item active">Menú de opciones.</li>
</ol>

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
      <h5 class="card-title">Ingresar a una semilla</h5>
            <input type='button' name='view' value='Presiona aquí' id='<?php echo $User ?>' class='btn btn-dark btn-block view_data'/>
    </div>
  </div>
 
</div>
<br> 


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
                     url:"includes/PertenecerSemilla.php",  
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
                  <h4 class="modal-title">Selecciona la semilla</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>
