<?php 
 
	function CrearUsuario($usuario, $FechaNacimiento, $N1, $N2, $A1, $A2, $rol, $Genero, $user, $Correo){
		require 'conexion.php';
		
		$Name = $N1." ".$N2." ".$A1." ".$A2;
		$Nickname = strtoupper(substr($N1, 0, 1).$A1.substr($usuario, -2, 2));
		$Password = md5($Nickname);

		$conexion -> query ("INSERT INTO control_password (Id_usuario, Estado) VALUES ($usuario, 1)");

		$IngresarPesona = "INSERT INTO usuario(Id_usuario, Nickname, Password, Name, Rol, Estado, FechaNacimiento, Genero, LiderSemilla, Correo) VALUES ($usuario, '$Nickname', '$Password', '$Name', '$rol', 1, '$FechaNacimiento', '$Genero', $user, '$Correo')";
		if ($conexion -> query ($IngresarPesona)) {
		    $Estado = 1 ; 
$cabeceras = 'From: admin@tusemilla.com.co';
$asunto = utf8_decode("¡Se ha creado tu cuenta en tusemilla!");
$mensaje="¡Hola, ".utf8_decode($Name)."! 

¡Felicitaciones! Queremos confirmarte que te has inscrito en la plataforma Tusemilla con éxito. TintoLibre te agradece por atreverte a cumplir tus sueños.
 
Ahora es el momento de inscribirte a tu semilla. Para esto tienes dos opciones: 
1. Puedes ingresar a tu semilla tu mismo, siguiendo estas instrucciones (texto de estas instrucciones con el link al video), o 
2. Cuando las demás personas ahorradoras de tu semilla se inscriban, el líder de tu semilla nombre del líder, te registrará. 

No dudes en contactarte con tu líder de semilla si tienes alguna duda.

¡Te felicitamos por tener la valentía de ahorrar por tus sueños!

Att: TintoLibre";


mail($Correo, $asunto, $mensaje, $cabeceras);

		}else{
			$Estado = $IngresarPesona; // Error
		}

		return $Estado;
	}
