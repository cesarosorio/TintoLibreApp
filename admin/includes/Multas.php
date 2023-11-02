<?php 

if (isset($_POST['VerMv'])) {
	$Semilla = $_POST['Semilla'];
	$Mvto = $_POST['Mvto'];
	$Usuario = $_POST['Usuario'];
	$Presidente = $_POST['Presidente'];

	$R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla FROM conformacion_semilla WHERE id_semilla = ".$Semilla)); 
	$Nombre_Semilla = $R['Nombre_Semilla'];

	$Cons = "SELECT mv.Id, mv.id_semilla, mv.Fecha, u.Name, mv.Observaciones, (mv.Valor+mv.aportesocial) as Recaudo, mv.Comprobante FROM mv_meta_semilla mv inner join usuario u on u.Id_usuario = mv.Id_usuario WHERE mv.id_semilla = $Semilla and mv.Id = $Mvto";
    $MP = $conexion -> query ($Cons);
    $Lee = mysqli_fetch_assoc($MP);

    $DatMultas= $conexion->query("SELECT mus.Id, mus.id_semilla, mus.NombreMulta, mus.ObserMultas, mus.Valor_Multa, mus.Fecha_Creacion, case when mus.Estado = 1 then 'Activo' else 'Inactivo' end as Estado FROM multas_semilla mus INNER JOIN usuario u on u.Id_usuario = mus.Presidente WHERE mus.Estado = 1 AND mus.id_semilla = ".$Semilla); 
?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item">Ver mis comprobantes.</li>
    <li class="breadcrumb-item"><strong>Semilla:</strong> <?php echo $Nombre_Semilla ?></li>
</ol>



<meta charset="utf-8">
  <table class="table table-bordered" width="100%" cellspacing="0"> 
    <thead>
      <tr align="center">
        <th align="center">Fecha</th> 
        <th align="center">Integrante</th> 
        <th align="center">Observaciones</th> 
        <th align="center">Recaudo</th> 
        <th align="center"><i class='fa fa-file-pdf-o' aria-hidden='true'></i></th> 
        <th align="center">Detalle</th>  
      </tr>
    </thead>
    <tbody>
		<?php $Cop = substr($Lee['Comprobante'], 6);
    		echo "<tr>
			<td>".$Lee['Fecha']."</td>  
			<td>".utf8_encode($Lee['Name'])."</td>  
               <td>".utf8_encode($Lee['Observaciones'])."</td>  
			<td align='right'>$".number_format($Lee['Recaudo'], 0)."</td>   
			<td aling='center'><a title='¡Click acá para ver el acta!' href='".$Cop."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td>  
			<td><input type='button' name='view' value='Ver' id='".$Lee['Id']."' class='btn btn-dark btn-block view_data'/></td>"; 
	    echo "</tr>";  ?>
    </tbody>
</table> 

<div class="alert alert-dark" role="alert">Multas a sancionar</div>

<meta charset="utf-8"> 
	<table class="table table-bordered" width="100%" cellspacing="0"> 
		<thead>
			<tr> 
				<td>Nro.</td>
				<td>Nombre</td>
				<td>Observaciones</td> 
				<td>Valor</td>  
				<td>Fecha de creación</td> 
				<td>Multar</td>    
			</tr>
		</thead>
		<tbody>
		<?php 
		$Nro = 0 ;
		while ($Le = mysqli_fetch_array($DatMultas)) { 
			$Nro++;
			echo "<tr>
				<td>".$Nro."</td>
				<td>".utf8_decode($Le['NombreMulta'])."</td>
				<td>".utf8_decode($Le['ObserMultas'])."</td>
				<td align='right'>$".number_format($Le['Valor_Multa'], 0)."</td>
				<td>".$Le['Fecha_Creacion']."</td>
				<td><form method='POST' class='form-register'>
                    <input type='hidden' name='Semilla' value='".$Semilla."'> 
                    <input type='hidden' name='Presidente' value='".$User."'>
                    <input type='hidden' name='Multa' value='".$Le['Id']."'>
                    <input type='hidden' name='Mvto' value='".$Mvto."'>
                    <input type='hidden' name='ValMulta' value='".$Le['Valor_Multa']."'>
                    <input name='MultarDef' class='btn btn-danger btn-block' type='submit' value='Multar'/></form></td> 
			</tr>";
		}  
		?>
		</tbody>
	</table> 

	<br> 
<div class="row"> 
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">	        
    <form action='?contenido=verMvto' method='POST' class='form-register'>
        <input type='hidden' name='Semilla' value="<?php echo $Semilla ?>">  
        <input type='hidden' name='AUser' value="<?php echo $Usuario ?>">  
        <input name='VerMv' class='btn btn-dark btn-block' type='submit' value='Volver'/>
    </form>
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
                     url:"includes/DistribucionValor.php",  
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
                  <h4 class="modal-title">Movimientos del valor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>      
                </div>  
                <div class="modal-body" id="employee_detail">  
                </div> 
                 
           </div>  
      </div>  
 </div> 
<?php } 

if (isset($_POST['MultarDef'])){
	
	date_default_timezone_set('america/bogota');
   	$Fecha = date("Y-m-d H:i:s");
    	
    $Semilla = $_POST['Semilla'];
	$Presidente = $_POST['Presidente'];
	$Mvto = $_POST['Mvto'];
	$ValMulta = $_POST['ValMulta'];
	$Multa = $_POST['Multa'];

	$R=mysqli_fetch_assoc($conexion->query("SELECT Lider_semilla FROM conformacion_semilla WHERE id_semilla = $Semilla")); 
	$Lider_semilla = $R['Lider_semilla'];

	$Val = ($Lider_semilla == $User) ? $Da = "viewSemilla" : $Da = "dwcomprobante" ;

	$R=mysqli_fetch_assoc($conexion->query("SELECT Valor FROM mv_meta_semilla WHERE Id = $Mvto AND id_semilla = $Semilla")); 
	$Valor = $R['Valor'];
	$NvValor = $Valor - $ValMulta ;
	$Val = ($Valor < $ValMulta) ? $Es = 1 : $Es = 0 ;

	if ($Es == 0) {
	 	$AsigMulta = "INSERT INTO mv_multa_semilla (id_semilla, Id_presidente, Id_mvto, Id_Multa, Valor_Multa, Fecha, Estado) VALUES ($Semilla, $Presidente, $Mvto, $Multa, $ValMulta, '$Fecha', 1)";
	 	if ($conexion -> query($AsigMulta)) {
			$ActPrincipal = "UPDATE mv_meta_semilla SET Valor = $NvValor WHERE Id = $Mvto AND id_semilla = $Semilla"; 
			if ($conexion -> query($ActPrincipal)) { 
				?><script languaje="javascript">
	                alert("¡Se aplico la multa!");
	                window.location="?contenido=<?php echo $Da; ?>";
	            </script><?php 
        	}
	 	}else{
	 		?><script languaje="javascript">
	            alert("¡Se aplico la multa, pero no se realizo el descuento del fondo social, por favor informar!");
	            window.location="?contenido=<?php echo $Da; ?>";
	        </script><?php
	 	}
	}else{
		?><script languaje="javascript">
            alert("¡No se aplico la multa! Debido a que es mayor al valor reposado");
            window.location="?contenido=<?php echo $Da; ?>";
        </script><?php
	}
}