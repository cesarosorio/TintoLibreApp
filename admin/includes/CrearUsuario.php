<?php 

if (isset($_POST['CrearUsuario'])) {
	
	require 'Funciones/CrearUsuario.php';

	$usuario=$_POST['usuario'];
	$FechaNacimiento=$_POST['FechaNacimiento'];
	$N1=$_POST['Name1'];
	$N2=$_POST['Name2'];
	$A1=$_POST['Name3'];
	$A2=$_POST['Name4'];
	$rol=$_POST['rol'];
	$Genero=$_POST['Genero'];
	$contenido=$_POST['contenido'];

	$Estado = CrearUsuario($usuario, $FechaNacimiento, $N1, $N2, $A1, $A2, $rol, $Genero, $User);

	if ($Estado == 1) { ?>
		<script languaje="javascript">
			window.location="?contenido=<?php echo $contenido ?>";
			alert("¡Se creo con exito al usuario!");
		</script>
	<?php }else{ ?>
		<script languaje="javascript">
			window.location="?contenido=<?php echo $contenido ?>";
			alert("¡Algo ocurrio y no se pudo crear!");
		</script>
	<?php } 
}
 