<?php
 
session_start();

include("conexion.php");
if (isset($_POST['login'])) {
	$user=strtoupper(utf8_decode($_POST['usuario']));
	$clave=md5(strtoupper(utf8_decode($_POST['password'])));
	$registro=utf8_decode($_POST['Ingreso']);
	$consulta=$conexion ->query ("SELECT * FROM usuario WHERE (Nickname='$user' OR Id_usuario = '$user') AND Password = '$clave' AND Estado = 1");
	$Permisos=$conexion ->query ("SELECT Rol FROM usuario WHERE (Nickname='$user' OR Id_usuario = '$user') AND Estado = 1");
	$Permiso=mysqli_fetch_row($Permisos);
	
	if ($Permiso[0] != NULL) { 
		if(mysqli_num_rows($consulta)>0){
			$rowlogin=mysqli_fetch_array($consulta);
			$_SESSION['user'] = $rowlogin['Nickname'];
			$_SESSION['registro'] = $registro;
			$_SESSION['ingresando'] = 1;
			$consultauser ="SELECT * FROM usuario WHERE Nickname = '".$_SESSION['user']."'";
			$conuser=mysqli_query($conexion,$consultauser);
			while ($userrow = $conuser->fetch_assoc()){ 

			$curl = curl_init();

    		curl_setopt_array($curl, array(
    			CURLOPT_URL => 'https://api103.hablame.co/api/sms/v3/send/priority',
    			CURLOPT_RETURNTRANSFER => true,
    			CURLOPT_ENCODING => '',
    			CURLOPT_MAXREDIRS => 10,
    			CURLOPT_TIMEOUT => 0,
    			CURLOPT_FOLLOWLOCATION => true,
    			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    			CURLOPT_CUSTOMREQUEST => 'POST',
    			CURLOPT_POSTFIELDS =>'{
    				"toNumber": "57'.utf8_encode($userrow['Celular']).'",
    				"sms": "Hola '.utf8_encode($userrow['Name']).', hemos identificado un inicio de sesion en Tusemilla.com.co" , 
    				"sc": "890202",
    				"request_dlvr_rcpt": 1					
    			}',
    
    			CURLOPT_HTTPHEADER => array(
    				'apiKey: WhagR4LbrYknK9lLHDjJ1tG3fRBtn4',
    				'token: d9730b796aae5d85ba8c2fd3fb0cf99a',
    				'account: 10015659',
    				'Content-Type: application/json'
    			),
    		));
    
    		$response = curl_exec($curl);
    		curl_close($curl);
			
			echo '<script> alert("Iniciando sesión para '.utf8_encode($userrow['Name']).'");</script>';
			echo "<script>window.location='admin/index.php';</script>";
		}
		}else{
			echo '<script> alert("Usuario o Contraseña incorrecta");</script>';
			echo '<script> window.location="index.php";</script>';
		}
	}else{
		echo '<script> alert("Usuario no habilitado para ingreso, consulte con el Administrador");</script>';
		echo '<script> window.location="index.php";</script>';
	}
 
}
?>