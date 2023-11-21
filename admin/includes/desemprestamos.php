<?php
error_reporting(0);
include 'conexion.php';
$pres = $_POST['employee_id'];

$R=mysqli_fetch_assoc($conexion->query("SELECT b.Banco, iff.NroCuenta, iff.TipoCuenta, p.Estado, p.Id, u.Name, cs.Nombre_Semilla, p.ValPrestamo, p.intereses, p.Justificacion, p.FechaSolicitud, p.FechaRespuesta, es.EstadoPrestamo FROM prestamos p INNER JOIN usuario u on u.Id_usuario = p.Id_responsable INNER JOIN conformacion_semilla cs on cs.id_semilla = p.id_semilla INNER JOIN estados_prestamos es on es.Id = p.Estado INNER JOIN info_usuarios iff on iff.Id_usuario = p.Id_responsable INNER JOIN bancos b on b.Id = iff.Banco WHERE p.Id = $pres GROUP BY p.Id"));  

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

     <div class="col-md-12"><br></div>

</div>
<div class="row"> 
     <div class="col-md-4">
          <strong>Banco: </strong><?php echo ($R['Banco']) ?>
     </div>
     <div class="col-md-4">
          <strong>Cuenta: </strong><?php echo utf8_encode($R['TipoCuenta']) ?>
     </div>
     <div class="col-md-4">
          <strong>Nro: </strong><?php echo $R['NroCuenta'] ?>
     </div>

     <div class="col-md-12"><br></div>

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
<?php if ($R['Estado'] == 8) { ?>
<form enctype="multipart/form-data" autocomplete="off" action="includes/ModPrestamo.php" method="POST">
	<div class="row"> 
		<div class="col-md-6"> 
	      	<div class="form-group"> 
				<input accept="application/pdf, image/*" class="form-control" type="file" name="Comprobante" required>
	     	</div> 
		</div> 
		<div class="col-md-6"> 
			<input type="hidden" name="IdPres" value="<?php echo $pres; ?>">  
		     <input type="submit" name="DesembolsarPrestamo" value="Desembolsar Prestamo" class="btn btn-dark btn-block">
		</div>
	</div>
</form> 
<?php } ?>
