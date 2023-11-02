<?php 

include 'conexion.php';

$MVTO =  $_POST['employee_id'];
$Presta = 0;	
$Multas = 0;
$Val_dd = 0;
$Consulta = "SELECT mv.Observaciones, mv.Valor, mv.aportesocial AS APS FROM mv_meta_semilla mv inner join conformacion_semilla cs on cs.id_semilla = cs.id_semilla where mv.Id = $MVTO";
$LeeCS = $conexion -> query ($Consulta);
$R = mysqli_fetch_assoc($LeeCS);
$VAS = $R['APS'];
$Valor = $R['Valor'];
$Observaciones = $R['Observaciones']; 

$VerMultas = $conexion->query("SELECT ms.NombreMulta, mu.Valor_multa FROM mv_multa_semilla mu INNER JOIN multas_semilla ms on ms.Id = mu.Id_multa WHERE mu.Id_mvto = $MVTO AND ms.NombreMulta != 'Otras deducciones' AND ms.ObserMultas != 'Valor que se cobra de forma mensual a cada Asociado/a por afiliacion a TintoLibre'");
$NMultas = mysqli_num_rows($VerMultas);
 
$Deducc = $conexion -> query ("SELECT ms.NombreMulta, mu.Valor_multa FROM mv_multa_semilla mu INNER JOIN multas_semilla ms on ms.Id = mu.Id_multa WHERE mu.Id_mvto = $MVTO AND ms.NombreMulta = 'Otras deducciones' AND ms.ObserMultas = 'Valor que se cobra de forma mensual a cada Asociado/a por afiliacion a TintoLibre'");
$R = mysqli_fetch_assoc($Deducc);
$NDeddcc = mysqli_num_rows($Deducc);


$VerPrestamos = $conexion->query("SELECT pes.Capital, pes.Intereses FROM mv_prestamos_sem pes where pes.Id_mvto = $MVTO");
$NPrestamos = mysqli_num_rows($VerPrestamos);



?> 
<strong>Observaciones del movimiento: </strong>
<br>
<br>
<table align="center" style="width: 50%">
	<tr>
		<td bgcolor="gray" align='center'><font color="white"><strong>Rubro</strong></font></td>
		<td bgcolor="gray" align='center'><font color="white"><strong>Valor</strong></font></td>
	</tr>
	<tr>
	 	<td>Fondo de ahorro: </td>
		<td align='right' colspan="2">$<?php echo number_format($Valor, 0) ?></td> 
	</tr>
	<tr>
		<td>Aporte Social: </td> 
		<td align='right'>$<?php echo number_format($VAS, 0) ?></td>
	</tr>
	<?php 
	if ($NMultas != 0) {  
		?>
		<tr>
			<td bgcolor="gray" align='center'><font color="white"><strong></strong></font></td>
			<td bgcolor="gray" align='center'><font color="white"><strong>Valor</strong></font></td>
		</tr>
		<?php while ($Le = mysqli_fetch_array($VerMultas)) { 
			echo "<tr>
				<td>".utf8_encode($Le['NombreMulta']).":</td>
				<td align='right'>$".number_format($Le['Valor_multa'], 0)."</td>
			</tr>";
			$Multas = $Multas + $Le['Valor_multa'];
		}?> 
	<?php } 
	if ($NPrestamos != 0) { ?>
		<tr>
			<td bgcolor="gray" align='center'><font color="white"><strong>Prestamos</strong></font></td>
			<td bgcolor="gray" align='center'><font color="white"><strong>Valor</strong></font></td>
		</tr>
		<?php while ($Pre = mysqli_fetch_array($VerPrestamos)) { 
			echo "<tr>
				<td>Pago a prestamos:</td>
				<td align='right'>$".number_format($Pre['Capital'], 0)."</td>
			</tr>
			<tr>
				<td>Intereses:</td>
				<td align='right'>$".number_format($Pre['Intereses'], 0)."</td>
			</tr>";
			$Presta = $Presta + $Pre['Capital'] + $Pre['Intereses'];
		}?> 
	<?php } 

	if ($NDeddcc != 0) {
		$Val_dd = $R['Valor_multa'];
	?>
		<tr>
			<td bgcolor="gray" align='center'><font color="white"><strong>Deducciones</strong></font></td>
			<td bgcolor="gray" align='center'><font color="white"><strong>Valor</strong></font></td>
		</tr>
		<tr>
			<td>Otras deducciones:</td>
			<td align='right'><?php echo number_format($Val_dd, 0) ?></td>
		</tr>
	<?php } ?>
	<tr> 
		<td><strong>Total</strong></td>
		<td align='right' colspan="2">$<?php echo number_format($Valor+$VAS+$Multas+$Presta+$Val_dd, 0) ?></td> 
	</tr>
</table>
