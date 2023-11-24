<?php
$conexion = new mysqli("database","tintoLibreApp","Ac1dl0v3!","tintoLibreApp");
if ($conexion -> connect_errno)
{
	die("Fallo conexion:(".$conexion -> mysqli_connect_errno().")".$conexion -> mysqli_connect_errno());
}
?>
