<?php 

include '../conexion.php';

$Sem = $_POST['employee_id'];
$R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla FROM conformacion_semilla WHERE id_semilla = ".$Sem)); 
$Nombre_Semilla = $R['Nombre_Semilla'];
?>

<form method="POST" action="includes/Semillas/FuncionesSemilla.php" class="form-register" name="RVH">
<div class="row">
  	<div class="col-md-6">
		<div class="form-group">
		    <label>Semilla</label>
		    <input class="form-control" type="text" name="Semilla" value="<?php echo $Nombre_Semilla ?>" readonly>
		</div>
	</div>

  	<div class="col-md-6">
		<div class="form-group">
	        <label>Persona</label>
	            <select name="Id_usuario" class="form-control" type="text" requerid> 
	            	<option></option>
		            <?php $query = $conexion -> query ("SELECT DISTINCT u.Id_usuario, u.Name FROM usuario u");
		                while ($admon = mysqli_fetch_array($query)) { 
		                	echo '<option value="'.$admon['Id_usuario'].'">'.$admon['Name'].'</option>'; 
	                } ?>
	            </select>
	    </div> 
  	</div>
  	
  	<div class="col-md-12">
  		<input type="hidden" name="Semilla" value="<?php echo $Sem ?>">
		<input name="aggp" class="btn btn-dark btn-block" type="submit" value="Registrarse"/>
  	</div>
</form>