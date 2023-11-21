<?php 

if (isset($_POST['Ver'])) {
	
	$Sem = $_POST['Semilla'];

	if (isset($_POST['Nombre']) AND isset($_POST['Valor']) AND isset($_POST['Observaciones'])) {

		date_default_timezone_set('america/bogota');
		$Fecha = date ("Y-m-d H:i:s");

		$Nombre = $_POST['Nombre'];
		$Valor = $_POST['Valor'];
		$Observaciones = $_POST['Observaciones'];

		$AggMulta = "INSERT INTO `multas_semilla`(id_semilla, Presidente, NombreMulta, ObserMultas, Valor_Multa, Fecha_Creacion, Estado) VALUES ($Sem, $User, '$Nombre', '$Observaciones', $Valor, '$Fecha', 1)";

		if ($conexion -> query ($AggMulta) ) {?>
            <script languaje="javascript">
                alert("¡Se registro la multa!");
            </script>
        <?php }else{ ?>
            <script languaje="javascript"> 
                alert("¡Por favor, intente de nuevo!");
            </script>
        <?php }
	}

	$R=mysqli_fetch_assoc($conexion->query("SELECT ms.id_semilla, ms.Nombre_Semilla FROM conformacion_semilla ms WHERE ms.id_semilla =  ".$Sem)); 
	$Nombre_Semilla = $R['Nombre_Semilla'];
	$id_semilla = $R['id_semilla'];

	$DatMultas= $conexion->query("SELECT mus.id_semilla, mus.NombreMulta, mus.ObserMultas, mus.Valor_Multa, mus.Fecha_Creacion, case when mus.Estado = 1 then 'Activo' else 'Inactivo' end as Estado FROM multas_semilla mus INNER JOIN usuario u on u.Id_usuario = mus.Presidente WHERE mus.id_semilla = ".$Sem); 

?>

<ol class="breadcrumb"> 
	<li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">Ver semillas.</li>
    <li class="breadcrumb-item active"><strong>Multas de la semilla:</strong> <?php echo $Nombre_Semilla ?> </li>
</ol>

<div class="row"> 
    <div class="col-md-12">
    	<input type='button' name='view' value='¡Dar click aqui para crear una multa!' id='<?php echo $Sem ?>' class='btn btn-dark btn-block view_data'/>
	</div> 
</div>

<br>	

<meta charset="utf-8"> 
	<table class="table table-bordered" width="100%" cellspacing="0"> 
		<thead>
			<tr> 
				<td>Nro.</td>
				<td>Nombre</td>
				<td>Observaciones</td> 
				<td>Valor</td>  
				<td>Fecha de creación</td> 
				<td>Estado</td>    
			</tr>
		</thead>
		<tbody>
		<?php 
		$Nro = 0 ;
		while ($Lee = mysqli_fetch_array($DatMultas)) { 
			$Nro++;
			echo "<tr>
				<td>".$Nro."</td>
				<td>".utf8_decode($Lee['NombreMulta'])."</td>
				<td>".utf8_decode($Lee['ObserMultas'])."</td>
				<td align='right'>$".number_format($Lee['Valor_Multa'], 0)."</td>
				<td>".$Lee['Fecha_Creacion']."</td>
				<td>".$Lee['Estado']."</td>
			</tr>";
		} 
		if ($Nro == 0) {
			echo "<tr>
				<td colspan='6' align='center'>No hay multas creadas al momento.</td>
			</tr>";
		}

		?>
		</tbody>
	</table> 

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
                     url:"includes/CrearMulta.php",  
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
                  <h4 class="modal-title">Creación de la multa a la semilla <?php echo $Nombre_Semilla ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div>
 
<?php }

