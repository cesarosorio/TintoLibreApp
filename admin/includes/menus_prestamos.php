<?php 

$Prest = $conexion->query("SELECT p.Id as Pres, p.Estado, es.EstadoPrestamo, cs.Nombre_Semilla, u.Name as Responsable, p.ValPrestamo, p.ValOrigin, IF(p.Tipo = 1, (SELECT SUM(Capital) FROM mv_prestamos_sem mp WHERE mp.Id_prestamo = p.Id), (SELECT SUM(Capital) FROM pasociacion mp WHERE mp.Id_prestam = p.Id AND mp.tipo = 2)) AS AbonoCapital, IF(p.Tipo = 1, (SELECT SUM(Intereses) FROM mv_prestamos_sem mp WHERE mp.Id_prestamo = p.Id), (SELECT SUM(Interesesc) FROM pasociacion mp WHERE mp.Id_prestam = p.Id AND mp.tipo = 2)) AS PagoIntereses FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla inner join estados_prestamos es on es.Id = p.Estado WHERE Id_responsable = $User");

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">Prestamos.</li>
</ol>

<div class="row"> 
    <div class="col-md-12">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <tr>
                <div class="alert alert-dark" role="alert">¿Necesitas solicitar un préstamo a los integrantes de tu semilla? Da click en el botón de abajo</div>
                <input type='button' name='view' value='Quiero solicitar un préstamo' id='<?php echo $User ?>' class='btn btn-dark btn-block view_data'/> 
            </tr>
        </table>
    </div> 
</div >

<div class="alert alert-dark" role="alert">En la siguiente tabla podrás ver cuáles préstamos se han solicitado y aprobado en tus semillas, cuánto se debe actualmente, el total prestado, cuánto han pagado en capital e intereses</div>

<meta charset="utf-8">
<div class="container-fluid">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
        <thead><tr align="center">  
            <td><strong>Estado</strong></td> 
            <td><strong>Semilla</strong></td> 
            <td><strong>Quién lo solicitó</strong></td> 
            <td><strong>Cúanto debo hoy</strong></td> 
            <td><strong>Valor del préstamo</strong></td> 
            <td><strong>Abono capital</strong></td> 
            <td><strong>Pago de intereses</strong></td> 
            <td><strong>Más detalles</strong></td>
        </tr></thead>
        <tbody>
        <?php while ($Le = mysqli_fetch_array($Prest)) {

            echo "<tr> 
                <td>".utf8_encode($Le['EstadoPrestamo'])."</td>
                <td>".utf8_encode($Le['Nombre_Semilla'])."</td>
                <td>".utf8_encode($Le['Responsable'])."</td> 
                <td align='right'>$".number_format($Le['ValPrestamo'], 0)."</td>
                <td align='right'>$".number_format($Le['ValOrigin'], 0)."</td>
                <td align='right'>$".number_format($Le['AbonoCapital'], 0)."</td>
                <td align='right'>$".number_format($Le['PagoIntereses'], 0)."</td>
                <td><form action='?contenido=detalleprestamos' method='POST' class='form-register'>
                    <input type='hidden' name='Prestamo' value='".$Le['Pres']."'>
                    <input name='Ver' class='btn btn-dark btn-block' type='submit' value='Ver'/>
                </form></td>
                  
            </tr>";
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