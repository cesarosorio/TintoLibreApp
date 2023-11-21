<?php $query = $conexion -> query ("SELECT p.Estado, p.Id, u.Name, cs.Nombre_Semilla, p.ValPrestamo,p.intereses, p.Justificacion, p.FechaSolicitud, es.EstadoPrestamo FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla INNER JOIN estados_prestamos es on es.Id = p.Estado WHERE cs.Lider_Semilla = $User GROUP BY p.Id");  
?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Ver semillas.</li>
</ol>

<meta charset="utf-8">
<div class="container-fluid">
  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
    <thead>
      <tr align="center"> 
        <td><strong>Solicitante</strong></td>
        <td><strong>Semilla</strong></td>
        <td><strong>Monto</strong></td> 
        <td><strong>%</strong></td> 
        <td><strong>Justificacion</strong></td>
        <td><strong>Fecha</strong></td>
        <td><strong>Estado</strong></td>
        <td><strong>¿Acciones?</strong></td>
        <td><strong>Desembolsar</strong></td>
       </tr>
    </thead>
    <tbody>
      <?php while ($Lee = mysqli_fetch_array($query)) { 
        echo "<tr>
          <td>".utf8_encode($Lee['Name'])."</td>
          <td>".utf8_encode($Lee['Nombre_Semilla'])."</td>
          <td align='right'>$".number_format($Lee['ValPrestamo'], 0)."</td> 
          <td align='right'>".number_format($Lee['intereses'], 2)."%</td> 
          <td>".($Lee['Justificacion'])."</td>
          <td align='right'>".substr($Lee['FechaSolicitud'], 0, 10)."</td> 
          <td>".$Lee['EstadoPrestamo']."</td>";
          if ($Lee['Estado'] != 2 AND $Lee['Estado'] != 8) {
               echo "<td><input type='button' name='view' value='Ver' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data'/></td>"; 
          }else{
               echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
          }
          if ($Lee['Estado'] == 8) {
               echo "<td><input type='button' name='view2' value='¡Go!' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data2'/></td>";
          }else{
               echo "<td align='center'><i class='fa fa-ban' aria-hidden='true'></i></td>";
          }
        echo "</tr>";
      } ?> 
    </tbody> 
  </table>
</div>

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
                     url:"includes/ValPrestamo.php",  
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
                  <h4 class="modal-title">Validación de préstamo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>

 <script>
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Insert");  
           $('#insert_form')[0].reset();  
      }); 
      $(document).on('click', '.view_data2', function(){  
           var employee_id = $(this).attr("id");  
           if(employee_id != '')  
           {  
                $.ajax({  
                     url:"includes/desemprestamos.php",
                     method:"POST",  
                     data:{employee_id:employee_id},  
                     success:function(data){  
                          $('#employee_detail2').html(data);  
                          $('#dataModal2').modal('show');  
                     }  
                });  
           }            
      });  
 });  
 </script>
 <div id="dataModal2" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">  
      <div class="modal-dialog modal-lg">  
           <div class="modal-content">  
                <div class="modal-header">
                  <h4 class="modal-title">Condiciones de acuerdo del prestamo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail2">  
                </div> 
                 
           </div>  
      </div>  
 </div>