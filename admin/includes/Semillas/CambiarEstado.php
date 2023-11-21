<?php 

include '../conexion.php';
$Sem = $_POST['employee_id'];
$R=mysqli_fetch_assoc($conexion->query("SELECT Estado_Semilla FROM conformacion_semilla ms WHERE ms.id_semilla =  ".$Sem));
$Estado_Semilla = $R['Estado_Semilla'];

$VerRolesSemilla ="SELECT DISTINCT Id_Estado, Nombre_Estado FROM estadosemillas WHERE Id_Estado <= 4  ";
$MP = $conexion->query($VerRolesSemilla);

?>
<form method="POST" action="includes/Semillas/FuncionesSemilla.php" class="form-register" name="RVH">
<?php while ($Lee=$MP->fetch_array(MYSQLI_BOTH)) {  

	if ($Lee['Id_Estado'] == $Estado_Semilla) { ?>
		<div class="col-md-12">
			<div class="form-group">
				<div class="form-check">
			  		<input class="form-check-input" type="radio" value="<?php echo $Lee['Id_Estado'] ?>" name="Estado_Semilla" checked><?php echo $Lee['Nombre_Estado'] ?>
				</div>		
			</div>
		</div>
	<?php }else{ ?>
		<div class="col-md-12">
			<div class="form-group">
				<div class="form-check">
			  		<input class="form-check-input" type="radio" value="<?php echo $Lee['Id_Estado'] ?>" name="Estado_Semilla"><?php echo $Lee['Nombre_Estado'] ?>
				</div>		
			</div>
		</div>
	<?php } 
} ?>

	<div class="col-md-12">
  		<input type="hidden" name="Semilla" value="<?php echo $Sem ?>">
		<input name="cessem" class="btn btn-dark btn-block" type="submit" value="Cambiar Estado"/>
  	</div>
</form>