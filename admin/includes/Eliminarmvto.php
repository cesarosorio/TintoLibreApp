<?php 
$Sem = $_POST['employee_id']; 
?>
Tenga en cuenta, que se eliminara toda la información relacionada al movimiento.
<br>
<hr>
<form method="POST" action="includes/procesoalerta.php" class="form-register" name="RVH">
<div class="row">
  	<div class="col-md-12">
  		<input type="hidden" name="Mvto" value="<?php echo $Sem ?>">
		<input name="Eliminar" class="btn btn-danger btn-block" type="submit" value="Sí"/>
  	</div>
</form>