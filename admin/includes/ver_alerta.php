<?php 

$Alertas = $conexion->query("SELECT a.Id, a.Fecha, cs.Nombre_Semilla, a.Observaciones, u.Name as Notifica FROM alertas a inner join conformacion_semilla cs on cs.Id_Semilla = a.Id_semilla inner join usuario u on u.Id_usuario = a.Id_notifica WHERE a.Estado = 1 AND cs.Lider_Semilla = ".$User);  

?>
<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Menú de opciones.</li>
    <li class="breadcrumb-item active">Alertas.</li>
</ol>


<meta charset="utf-8"> 
	<table class="table table-bordered" width="100%" cellspacing="0"> 
		<thead>
			<tr align="center"> 
				<td><strong>Nro</strong></td>
				<td><strong>Fecha</strong></td>
				<td><strong>Semilla</strong></td>
				<td><strong>Observaciones</strong></td>
				<td><strong>Notifica</strong></td> 
				<td><strong>Validar</strong></td>  
			</tr>
		</thead>
		<tbody>
		<?php $Nro = 0 ; while ($Lee = mysqli_fetch_array($Alertas)) { 
			$Nro++;
			echo "<tr>
				<td>".$Nro."</td>
				<td>".$Lee['Fecha']."</td>
				<td>".utf8_decode($Lee['Nombre_Semilla'])."</td>
				<td>".($Lee['Observaciones'])."</td>
				<td>".utf8_decode($Lee['Notifica'])."</td>
				<td><form action='?contenido=edit_alerta' method='POST' class='form-register'>
					<input type='hidden' name='id' value='".$Lee['Id']."'> 
					<input name='VerAlerta' class='btn btn-dark btn-block' type='submit' value='Ver'/>
				</form></td>
			</tr>";
		} ?>
		</tbody>
	</table> 
