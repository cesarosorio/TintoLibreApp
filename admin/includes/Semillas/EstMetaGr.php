<?php 
include '../conexion.php';

$Sem = $_POST['employee_id']; 
$R=mysqli_fetch_assoc($conexion->query("SELECT ms.FechaCierre, ms.Nombre_Semilla, ms.aportesocial, ms.minimo, ms.maximo, ms.montoPrestamo FROM conformacion_semilla ms WHERE ms.id_semilla =  ".$Sem)); ;
$Nombre_Semilla = $R['Nombre_Semilla']; 
$aportesocial = $R['aportesocial'];
$FechaCierre = $R['FechaCierre'];  
$minimo = $R['minimo'];
$maximo = $R['maximo'];
$montoPrestamo = $R['montoPrestamo'];
?>
<form method="POST" action="includes/Semillas/FuncionesSemilla.php" class="form-register" name="RVH">
<div class="row">

  	<div class="col-md-5">
		<label>Nombre de la semilla</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="text" name="Nombre" value="<?php echo $Nombre_Semilla ?>" required>
		</div>
	</div>

	<div class="col-md-5">
		<label>Aporte social</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="number" name="aportesocial" value="<?php echo $aportesocial ?>" required>
		</div>
	</div>

	<div class="col-md-5">
		<label>Monto de préstamo</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="number" name="montoprestamo" value="<?php echo $montoPrestamo ?>" required>
		</div>
	</div>

	<div class="col-md-5">
		<label>Mínimo de consignación</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="number" name="minimo" value="<?php echo $minimo ?>" required>
		</div>
	</div>

	<div class="col-md-5">
		<label>Máximo de consignación</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="number" name="maximo" value="<?php echo $maximo ?>" required>
		</div>
	</div>

  	<div class="col-md-5">
		<label>Modificar fecha de cierre</label>
	</div>
  	
  	<div class="col-md-7">
		<div class="form-group">
			<input class="form-control" type="date" name="FechaCierre" value="<?php echo $FechaCierre ?>" required>
		</div>
	</div>

  	<div class="col-md-12">
  		<input type="hidden" name="Semilla" value="<?php echo $Sem ?>">
		<input name="aggm" class="btn btn-dark btn-block" type="submit" value="Actualizar"/>
  	</div>
</form>