<?php 

require 'admin/includes/Funciones/CrearUsuario.php';
$usuario=rtrim($_POST['usuario']);
$FechaNacimiento=$_POST['FechaNacimiento'];
$user=$_POST['Lider'];
$N1=rtrim($_POST['Name1']);
$A1=rtrim($_POST['Name2']);
$A2=rtrim($_POST['Name3']);
$Genero=$_POST['Genero'];
$Correo=rtrim($_POST['Correo']);

$Nickname = strtoupper(substr($N1, 0, 1).$A1.substr($usuario, -2, 2));

$Estado=CrearUsuario($usuario, $FechaNacimiento, $N1, "", $A1, $A2, 5, $Genero, $user, $Correo);

if ($Estado == 1) { ?>
	<script languaje="javascript">
		window.location="index.php";
		alert("¡Se creo con exito al usuario! Su usuario y contraseña es <?php echo $Nickname; ?>");
	</script>
<?php }else{ echo $Estado; ?>
	<script languaje="javascript">
		window.location="registronuevo.php";
		alert(<?php echo $Estado; ?>"¡Algo ocurrio y no se pudo crear!");
	</script>
<?php } 
 