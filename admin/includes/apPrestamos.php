<?php 
include 'conexion.php';
$pres = $_POST['employee_id'];

$R=mysqli_fetch_assoc($conexion->query("SELECT p.Estado, p.Id, u.Name, cs.Nombre_Semilla, p.ValPrestamo, p.valcuota, p.intereses, p.numcuotas, p.Justificacion, p.FechaSolicitud, p.FechaRespuesta, es.EstadoPrestamo FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla INNER JOIN estados_prestamos es on es.Id = p.Estado WHERE p.Id = $pres GROUP BY p.Id"));  

?>

<div class="row"> 
     <div class="col-md-4">
          <strong>Semilla: </strong><?php echo utf8_encode($R['Nombre_Semilla']) ?>
     </div>
     <div class="col-md-4">
          <strong>Justificacion: </strong><?php echo utf8_encode($R['Justificacion']) ?>
     </div>
     <div class="col-md-4">
          <strong>Solicitado: </strong>$<?php echo number_format($R['ValPrestamo'], 0) ?>
     </div>
</div>
<div class="row">
     <div class="col-md-4">
          <strong>Solicitado: </strong><?php echo ($R['FechaSolicitud']) ?>
     </div>
     <div class="col-md-4">
          <strong>Aprobado: </strong><?php echo ($R['FechaRespuesta']) ?>
     </div>
     <div class="col-md-4">
          <strong>Estado: </strong><?php echo utf8_encode($R['EstadoPrestamo']) ?>
     </div>
</div>
<hr>
Reglas del juego
<hr>
	<table align="center" style="width: 70%">
		<tr>
			<td bgcolor="gray" align='center'><font color="white"><strong>Valor cuota</strong></font></td> 
			<td bgcolor="gray" align='center'><font color="white"><strong>% intereses</strong></font></td> 
			<td bgcolor="gray" align='center'><font color="white"><strong>Valor intereses</strong></font></td> 
			<td bgcolor="gray" align='center'><font color="white"><strong>Total por mes</strong></font></td> 
		</tr>
	
	<?php $Total=0; for ($i=1; $i <= $R['numcuotas'] ; $i++) {  
		$Valintereses = $R['valcuota']*($R['intereses']/100);
		$ValTotalMes = $R['valcuota']+$Valintereses;
		$Total = $Total + $ValTotalMes;
	?>
		<tr>
			<td align='right'>$<?php echo number_format($R['valcuota'], 0, ",", ".") ?></td> 
			<td align='right'><?php echo number_format(round($R['intereses'], 2), 2, ",", ".") ?>%</td>   
			<td align='right'>$<?php echo number_format($Valintereses, 0, ",", ".") ?></td>   
			<td align='right'>$<?php echo number_format($ValTotalMes, 0, ",", ".") ?></td>   
		</tr>
	<?php } ?>
		<tr>
			<td bgcolor="gray" align='right' colspan="3"><font color="white"><strong>Total</strong></font></td>
			<td bgcolor="gray" align='right'><font color="white"><strong>$<?php echo number_format($Total, 0, ",", ".") ?></strong></font></td>
		</tr>
	</table>
<br>
<div class="row"> 
     <div class="col-md-12">
     	<?php if ($R['Estado'] != 8) { ?> 
			<form autocomplete="off" action="includes/ModPrestamo.php" method="POST">
				<input type="hidden" name="IdPres" value="<?php echo $pres; ?>">  
	          	<input type="submit" name="AcepPrestamo" value="Aceptar Prestamo" class="btn btn-dark btn-block">
	     	</form>
     	<?php } ?>
     </div>
 </div>

