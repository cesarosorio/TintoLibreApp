<?php 

$Alertas = $conexion->query("SELECT U.Id_usuario, U.Nickname, U.Name, U.Estado, IF(U.Estado = 1, 'Activo', 'Inactivo') NEstado, U.Correo, U.Celular, UU.Name Lider FROM usuario U INNER JOIN usuario UU ON UU.Id_usuario = U.LiderSemilla ORDER BY U.Estado DESC");  

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Administración personal.</li> 
</ol>	

<meta charset="utf-8">
<div class="container-fluid">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr> 
				<td><strong>Nro</strong></td>
				<td><strong>Nickname</strong></td>
				<td><strong>Nombre</strong></td>
				<td><strong>Estado</strong></td>
				<td><strong>Correo</strong></td> 
				<td><strong>Celular</strong></td>  
				<td><strong>Lider</strong></td>  
				<td><strong>Ver</strong></td>  
			</tr>
		</thead>
		<tbody>
		<?php $Nro = 0 ; while ($Lee = mysqli_fetch_array($Alertas)) { 
			$Nro++;
            $NameStatus = ($Lee['Estado'] == 1 ) ? 'Inactivar' : 'Activar' ; 
			echo "<tr>
				<td>".$Nro."</td>
				<td>".$Lee['Nickname']."</td>
				<td>".$Lee['Name']."</td>
				<td>".$Lee['NEstado']."</td>
				<td>".$Lee['Correo']."</td>
				<td>".$Lee['Celular']."</td>
				<td>".$Lee['Lider']."</td>				
                <td><input type='button' name='view' value='".$NameStatus."' id='".$Lee['Id_usuario']."' class='btn btn-dark btn-block view_data'/></td>
			</tr>";
		} ?>
    </tbody>
  </table>
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
                     url:"includes/Inactivar_persona.php",  
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
                  <h4 class="modal-title">¿Esta seguro de cambiar el estado de la persona?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>