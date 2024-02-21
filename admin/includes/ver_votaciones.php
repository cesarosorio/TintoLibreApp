<?php 

if (isset($_POST['VerVota'])) {
	$id_v = $_POST['id_v'];
	$integrantes = 1;
	if ($_POST['integrantes'] > 0) {
		$integrantes = $_POST['integrantes'];
	}
	$R=mysqli_fetch_assoc($conexion -> query("SELECT Id_prestamo, Id_semilla FROM votaciones where id = $id_v"));
	$Prestamo = $R['Id_prestamo'];
	$Id_semilla = $R['Id_semilla'];
	
	$R=mysqli_fetch_assoc($conexion -> query("SELECT lider_semilla FROM conformacion_semilla where Id_semilla = $Id_semilla"));
	$lider_semilla = $R['lider_semilla'];

	$R=mysqli_fetch_assoc($conexion -> query("SELECT COUNT(*) AS Voto FROM votaciones_part where id_persona = $User AND id_votacion = $id_v"));
	$Voto = $R['Voto'];

	$R=mysqli_fetch_assoc($conexion->query("SELECT p.Id_responsable, p.URLComprobante, p.intereses, p.Estado, u.Name, c.Nombre_Semilla, p.Justificacion, p.ValOrigin, p.ValPrestamo, case when p.FechaSolicitud is null then 'No aplica' else p.FechaSolicitud end fs, case when p.FechaRespuesta is null then 'No aplica' else p.FechaRespuesta end fr, case when p.FechaPrestamo is null then 'No aplica' else p.FechaPrestamo end fp, es.EstadoPrestamo FROM prestamos p inner join usuario u on u.Id_usuario = p.Id_responsable inner join conformacion_semilla c on c.Id_Semilla = p.Id_semilla inner join estados_prestamos es on es.Id = p.Estado where p.id = $Prestamo"));
	$cons = "SELECT u.Name, case when vp.opcion = 1 then 'Sí' else 'No' end as opcion, vp.Fecha FROM votaciones_part vp inner join usuario u on u.Id_usuario = vp.Id_persona WHERE id_votacion = $id_v";
	$Query = $conexion->query($cons); 

	$Vt=mysqli_fetch_assoc($conexion -> query("SELECT * from (
		(SELECT COUNT(1) Si_v FROM votaciones_part WHERE opcion = 1 and id_votacion=$id_v) as Si_v,
		(SELECT COUNT(1) No_v FROM votaciones_part WHERE opcion = 2 and id_votacion=$id_v) as No_v
	)"));
	$Si = $Vt['Si_v'];
	$No = $Vt['No_v'];

	$NVotos = $Si+$No;

	$part_si = ($NVotos != 0) ? ($Si/$integrantes)*100 : 0 ;
	$part_no = ($NVotos != 0) ? ($No/$integrantes)*100 : 0 ;



?>

<ol class="breadcrumb"> 
    <li class="breadcrumb-item">Ver votaciones</li>
    <li class="breadcrumb-item active"><strong>ID: </strong><?php echo $id_v ?></li>
</ol>

<div class="row"> 
     <div class="col-md-4">
          <strong>Semilla: </strong><?php echo utf8_encode($R['Nombre_Semilla']) ?>
     </div>
     <div class="col-md-4">
          <strong>Justificacion: </strong><?php echo utf8_encode($R['Justificacion']) ?>
     </div>
     <div class="col-md-4">
          <strong>Valor del prestamo: </strong>$<?php echo number_format($R['ValOrigin'], 0) ?>
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
          <strong>Fecha prestamo: </strong><?php echo ($R['fp']) ?>
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


<?php 
if (($Voto == 0 AND $User != $lider_semilla) || ($_POST['integrantes'] == 0 AND $User == $lider_semilla)) {

	if ($User != $R['Id_responsable'] || ($_POST['integrantes'] == 0 AND $User == $lider_semilla)) { ?>

	<form action="includes/prestamos.php" method="POST" class="form-register">

		<div class="row"> 
		     <div class="col-md-4">
		          <strong>Vote aquí:</strong>
		     </div>

		     <div class="col-md-4">
				<div class="form-group">
				<select list="opcion" class="form-control" type="text" name="opcion" required>  
		        	<option></option>
		        	<option value="1">Sí</option>
		        	<option value="2">No</option>
		        </select>
				</div>
		     </div>

		     <div class="col-md-4">
		     	<input type="hidden" name="Persona" value="<?php echo $User ?>">
		     	<input type="hidden" name="integrantes" value="<?php echo $integrantes ?>">
		     	<input type="hidden" name="Id_v" value="<?php echo $id_v ?>">
		     	<input type="hidden" name="Prestamo" value="<?php echo $Prestamo ?>">
	        	<input name="AgregarVoto" class="btn btn-dark btn-block" type="submit" value="Votar"/>     
		     	
		     </div>
		     
		     <div class="col-md-12"><br></div>
		     <div class="col-md-12"><hr></div>

		</div> 
	</form>
	 
	<?php } ?>	

<?php } ?>

<div class="row"> 
     <div class="col-md-12" align="center">
          <strong>RESUMEN DE VOTACIÓN</strong>
     </div>
     
     <div class="col-md-12"><hr></div>

     <div class="col-md-6" align="center">
          <strong>Sí</strong>
     </div>
     
     <div class="col-md-6" align="center">
          <strong>No</strong>
     </div>
 
     <div class="col-md-12"><hr></div>
	 
	<div class="col-md-6" align="center">
		<?php echo $Si." (".round($part_si, 2)."%)"; ?>
	</div>

	<div class="col-md-6" align="center">
		<?php echo $No." (".round($part_no, 2)."%)"; ?>
	</div>


	<div class="col-md-12"><hr></div>

	<div class="col-md-12" align="right">
		<?php $val = ($NVotos == 0) ? $part = 0 : $part = ($NVotos/$integrantes)*100 ;
		 echo "<strong>".$NVotos."</strong> de <strong>".$integrantes."</strong> votos, para un total de <strong>".round($part, 2)."%</strong>"; ?>
	</div> 
	<div class="col-md-12"><hr></div>

</div> 

<?php } ?>
