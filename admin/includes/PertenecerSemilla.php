<?php 
include 'conexion.php';

$User = $_POST['employee_id'];

?>

<form method="POST" action="includes/Semillas/FuncionesSemilla.php" class="form-register" name="RVH">
<div class="row">
  	<div class="col-md-12">
		<div class="form-group">
	        <label>Elige la semilla</label>
	            <select name="Semilla" class="form-control" type="text" requerid> 
	            	<option></option>
		            <?php $query = $conexion -> query ("SELECT Id_semilla, Nombre_semilla FROM conformacion_semilla WHERE Estado_Semilla = 1;");
		                while ($admon = mysqli_fetch_array($query)) { 
		                	echo '<option value="'.$admon['Id_semilla'].'">'.$admon['Nombre_semilla'].'</option>'; 
	                } ?>
	            </select>
	    </div> 
  	</div>
  	
  	<div class="col-md-12"> 
  		<input type="hidden" name="Id_usuario" value="<?php echo $User ?>">
		<input name="aggpp" class="btn btn-dark btn-block" type="submit" value="Registrarse"/> 
  	</div>
</form>