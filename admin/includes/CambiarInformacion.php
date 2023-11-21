<?php 

include 'conexion.php';

if (isset($_POST['CambInformacion'])) {
	
	$correo=$_POST['correo'];
	$celular=$_POST['celular'];
	$FechaNacimiento=$_POST['FechaNacimiento'];
	$password=($_POST['password']);
	$Banco=$_POST['Banco'];
	$Cuenta=$_POST['Cuenta'];
	$NroCuenta=$_POST['NroCuenta'];
	$User=$_POST['User'];
	$Titular=$_POST['Titular'];
	$CedulaTit=$_POST['CedulaTit'];

	$conexion->query("UPDATE control_password SET Estado = 2 WHERE id_usuario = ".$User);
	
	$CompContraseña = $conexion->query("SELECT password as Esta FROM usuario WHERE Id_usuario = $User");
	$R=mysqli_fetch_assoc($CompContraseña);
	$Esta = $R['Esta'];

	$Val = ($Esta == $password) ? $Campo = '' : $Campo = ", password = '".md5($password)."' " ;
	
	$ActuInfo = "UPDATE usuario SET correo = '$correo' , celular = '$celular', FechaNacimiento = '$FechaNacimiento' $Campo WHERE Id_usuario = $User "; 
	if ($conexion -> query($ActuInfo)) {
		$Data = $conexion -> query("SELECT Id_usuario FROM info_usuarios WHERE Id_usuario = $User");
		$NroDatos = mysqli_num_rows($Data);
		if ($NroDatos == 0) {
			$Agg="INSERT INTO info_usuarios (Id_usuario, TipoCuenta, NroCuenta, Banco, Titular, CedulaTit) VALUES ($User, '$Cuenta', $NroCuenta, $Banco, '$Titular', '$CedulaTit')";
			if ($conexion->query($Agg)) {
				?><script languaje="javascript">
	                window.location="../index.php?contenido=info_perso";
	                alert("¡Excelente, se actualizo la información!");
            	</script><?php
			}else{
				?><script languaje="javascript">
	                window.location="../index.php?contenido=info_perso";
	                alert("¡Excelente, se actualizo la información, pero algo ocurrio con la información bancaria!");
            	</script><?php
			}
		}else{
			$Upt = "UPDATE info_usuarios SET TipoCuenta = '$Cuenta', NroCuenta = $NroCuenta, Banco = $Banco, Titular = '$Titular', CedulaTit = '$CedulaTit' WHERE Id_usuario = $User ";
			if ($conexion->query($Upt)) {
				?><script languaje="javascript">
	                window.location="../index.php?contenido=info_perso";
	                alert("¡Excelente, se actualizo la información!");
            	</script><?php
			}else{
				?><script languaje="javascript">
	                window.location="../index.php?contenido=info_perso";
	                alert("¡Excelente, se actualizo la información, pero algo ocurrio con la información bancaria!");
            	</script><?php
			}
		}
	}else{
		?><script languaje="javascript">
	        window.location="?contenido=info_perso";
	        alert("¡Ocurrio algun error, contactate con el administrador del sistema - CODERROR-UPPBANC!");
		</script><?php
	}
}