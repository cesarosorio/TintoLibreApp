<?php 

$Prestamo = $_POST['Prestamo'];

$R=mysqli_fetch_assoc($conexion->query("SELECT p.Tipo, p.URLComprobante, p.intereses, p.Estado, u.Name, c.Nombre_Semilla, p.Justificacion, p.ValOrigin, p.ValPrestamo, case when p.FechaSolicitud is null then 'No aplica' else p.FechaSolicitud end fs, case when p.FechaRespuesta is null then 'No aplica' else p.FechaRespuesta end fr, case when p.FechaPrestamo is null then 'No aplica' else p.FechaPrestamo end fp, es.EstadoPrestamo FROM prestamos p inner join usuario u on u.Id_usuario = p.Id_responsable inner join conformacion_semilla c on c.Id_Semilla = p.Id_semilla inner join estados_prestamos es on es.Id = p.Estado where p.id = $Prestamo"));


?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de préstamos.</li>
    <li class="breadcrumb-item">Préstamo.</li>
</ol>

<div class="row"> 
     <div class="col-md-4">
          <strong>Semilla: </strong><?php echo utf8_encode($R['Nombre_Semilla']) ?>
     </div>
     <div class="col-md-4">
          <strong>Justificacion: </strong><?php echo utf8_encode($R['Justificacion']) ?>
     </div>
     <div class="col-md-4">
          <strong>Valor del préstamo: </strong>$<?php echo number_format($R['ValOrigin'], 0) ?>
     </div>
     
     <div class="col-md-12"><br></div>

</div>

<div class="row"> 
     <div class="col-md-4">
          <strong>Responsable: </strong><?php echo utf8_encode($R['Name']) ?>
     </div>
     <div class="col-md-4">
          <strong>Fecha solicitud: </strong><?php echo ($R['fs']) ?>
     </div>
     <div class="col-md-4">
          <strong>Fecha respuesta: </strong><?php echo ($R['fr']) ?>
     </div>
     
     <div class="col-md-12"><br></div>

</div>

<div class="row"> 
     <div class="col-md-4">
          <strong>Fecha préstamo: </strong><?php echo ($R['fp']) ?>
     </div>
     <div class="col-md-4">
          <strong>Estado: </strong><?php echo utf8_encode($R['EstadoPrestamo']) ?>
     </div>
     <div class="col-md-4">
          <strong>Fecha respuesta: </strong><?php echo ($R['fr']) ?>
     </div>
     
     <div class="col-md-12"><br></div>

     <div class="col-md-12"><hr></div>

</div>

<?php if ($R['Estado'] == 2) { ?>

<div class="row"> 
     <div class="col-md-4">
          <strong>Intereses de préstamo: </strong><?php echo ($R['intereses']) ?>%
     </div>
     <div class="col-md-4">
          <strong>Primera cuota mínima: </strong>$<?php echo number_format(($R['intereses'])/100*$R['ValPrestamo']) ?>
     </div>
     <div class="col-md-4">
          <td><input type='button' name='view' value='Aceptar préstamo' id='<?php echo $Prestamo ?>' class='btn btn-dark btn-block view_data'/></td>
     </div>
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
                     url:"includes/AceptarPrestamo.php",  
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
                  <h4 class="modal-title">¿Esta seguro de aceptar el préstamo?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>

<?php } ?>

<?php if ($R['Estado'] == 6 OR $R['Estado'] == 7) { 
$Cop = substr($R['URLComprobante'], 6); 

$val = ($R['ValPrestamo'] == 0 or $R['ValOrigin'] == 0) ? $Por = 0 : $Por = ($R['ValPrestamo']/$R['ValOrigin'])*100 ; 
?>
<div class="row"> 
     <div class="col-md-3">
          <strong>Comprobante: </strong><a title='¡Click acá para ver el acta!' href='<?php echo $Cop ?>' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>
     </div>

     <div class="col-md-3">
          <strong>Intereses de préstamo: </strong><?php echo ($R['intereses']) ?>%
     </div>

     <div class="col-md-3">
          <strong>Monto restante: </strong>$<?php echo number_format($R['ValPrestamo']) ?>
     </div>
     <div class="col-md-3">
          <strong>Porcentaje: </strong><?php echo number_format(round($Por, 2), 2) ?>%
     </div>

     <div class='col-md-12'><hr></div>

     <div class='col-md-12' align="center">Movimientos del prestamo</div>
     
     <div class='col-md-12'><hr></div>

     <div class='col-md-3'>Id</div>
     <div class='col-md-3'>Fecha</div>
     <div class='col-md-3'>Capital</div>
     <div class='col-md-3'>Intereses</div>

     <div class='col-md-12'><hr></div>
     <?php 
     if($R['Tipo'] == 1)
          $P = $conexion->query("SELECT mp.Id, mp.Fecha, mp.Capital, mp.Intereses FROM mv_prestamos_sem mp WHERE mp.Id_prestamo = $Prestamo ");
     else
          $P = $conexion->query("SELECT mp.Id, mp.Fecha_pago Fecha, mp.Capital, mp.Interesesc Intereses FROM pasociacion mp WHERE mp.Tipo = 2 AND mp.Id_prestam = $Prestamo ");


     while ($LP = mysqli_fetch_array($P)) { ?>
         <div class='col-md-3'><?php echo $LP['Id'] ?></div>
         <div class='col-md-3'><?php echo $LP['Fecha'] ?></div>
         <div class='col-md-3'>$<?php echo number_format($LP['Capital']) ?></div>
         <div class='col-md-3'>$<?php echo number_format(round($LP['Intereses'], 0), 0) ?></div>
       
     <?php } ?>


</div>
<?php } ?>