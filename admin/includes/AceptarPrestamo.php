<?php 
include 'conexion.php';

$pres = $_POST['employee_id'];

?>

<form action="includes/ModPrestamo.php" method="POST">
	<input type="hidden" name="IdPres" value="<?php echo $pres ?>">
    <input type="submit" name="AcepPrestamo" value="Aceptar Prestamo" class="btn btn-dark btn-block">
</form>