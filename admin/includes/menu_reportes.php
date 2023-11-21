<ol class="breadcrumb"> 
    <li class="breadcrumb-item active">Menú de opciones.</li>
</ol>

<div class="card-deck">
  
  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">De consignacion mensual</h5>
      <input type='button' name='view' value='Ver' id='1' class='btn btn-dark btn-block view_data'/></td>
    </div>
  </div>

  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Total ahorrado por semilla</h5>
      <input type='button' name='view' value='Ver' id='2' class='btn btn-dark btn-block view_data'/></td>
    </div>
  </div>

  <div class="card"> 
    <div class="card-body">
      <h5 class="card-title">Estado de cuentas</h5>
      <input type='button' name='view' value='Ver' id='3' class='btn btn-dark btn-block view_data'/></td>
    </div>
  </div>
 
</div>


<!-- Reporte Mensual -->
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
                     url:"includes/report_consigmens.php",  
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
                  <h4 class="modal-title">Seleccione los parametros</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>