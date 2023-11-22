<?php
#$conexion = new mysqli("localhost","u933403530_tintolibre","wQ0dZN^0f#C41@CG","u933403530_tintolibre");
$conexion = new mysqli("database","tintoLibreApp","Ac1dl0v3!","tintoLibreApp");
if ($conexion -> connect_errno)
{
	die("Fallo conexion:(".$conexion -> mysqli_connect_errno().")".$conexion -> mysqli_connect_errno());
}
?>
