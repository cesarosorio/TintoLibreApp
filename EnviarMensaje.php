<?php

include 'conexion.php';

$consulta="SELECT u.Id_usuario, cs.Id_Semilla, u.Name, cs.Nombre_Semilla, u.Celular, DAY(NOW()), dp.quimaximo, dp.quimaxidos, dp.mesmaximo, DAY(NOW())-dp.quimaximo as Uno, DAY(NOW())-dp.quimaxidos as Dos, DAY(NOW())-dp.mesmaximo as Tre FROM usuario u inner join integrantes_semilla iss on iss.Id_persona = u.Id_usuario inner join conformacion_semilla cs on cs.Id_Semilla = iss.Id_semilla inner join diasparapago dp on dp.Id_semilla = cs.Id_Semilla WHERE u.Rol != 1";
$Query = $conexion->query($consulta);
while ($dt = mysqli_fetch_array($Query)) {

	$Id_usuario = $dt['Id_usuario'];
	$nombre = $dt['Name'];
	$celular = $dt['Celular'];
	$semilla = $dt['Nombre_Semilla'];
	$Id_Semilla = $dt['Id_Semilla'];
	 
	if ($dt['Uno'] == -7 OR $dt['Dos'] == -7 OR $dt['Tre'] == -7) {

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
				"toNumber": "57'.$celular.'",
				"sms": "Hola '.$nombre.', TintoLibre te recuerda que está semana debes consignar y registrar tu aporte a la Semilla. Así estarás más cerca de cumplir tu sueño." , 
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
		
	}elseif($dt['Uno'] == -2 OR $dt['Dos'] == -2 OR $dt['Tre'] == -2){

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
				"toNumber": "57'.$celular.'",
				"sms": "Hola '.$nombre.', te recordamos que tienes dos días para hacer el depósito de dinero en la cuenta y registrarlo en '.$semilla.' para que estés cada vez más cerca de cumplir tu sueño. Att: TintoLibre." , 
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

	}elseif($dt['Uno'] == 7 OR $dt['Dos'] == 7 OR $dt['Tre'] == 7){  

		$R=mysqli_fetch_assoc($conexion->query("SELECT (SELECT ifnull(SUM(Valor), 0) FROM mv_meta_semilla WHERE id_usuario = $Id_usuario AND id_semilla = $Id_Semilla AND YEAR(Fecha) = YEAR(NOW()) AND MONTH(Fecha) = MONTH(NOW())) AS AhorroMes, (SELECT ifnull(SUM(Valor), 0) FROM mv_meta_semilla WHERE id_semilla = $Id_Semilla AND YEAR(Fecha) = YEAR(NOW()) AND MONTH(Fecha) = MONTH(NOW()) ) AS AhorroSemilla, (SELECT ifnull(SUM(AporteSocial), 0) FROM mv_meta_semilla WHERE id_semilla = $Id_Semilla AND YEAR(Fecha) = YEAR(NOW()) AND MONTH(Fecha) = MONTH(NOW())) AS FondoSemilla")); 

		$AhorroMes = $R['AhorroMes']; 
		$AhorroSemilla = $R['AhorroSemilla'];
		$FondoSemilla = $R['FondoSemilla'];
 		
		if($AhorroMes != 0) {
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
    				"toNumber": "57'.$celular.'",
    				"sms": "Hola '.$nombre.', tu ahorro de este mes fue de $'.number_format($AhorroMes, 0).', el ahorro de tu semilla fue de $'.number_format($AhorroSemilla, 0).', y el total en el fondo de emergencia de tu semilla es de $'.number_format($FondoSemilla, 0).' correspondiente a tu semilla: '.$semilla.'. Att: TintoLibre. " , 
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
		}
	} 

}