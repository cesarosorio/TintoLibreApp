<?php 

function IntegSem($Id_usuario, $Semilla){
	require 'conexion.php';

    date_default_timezone_set('america/bogota');
	$Fecha = date ("Y-m-d");

	$R=mysqli_fetch_assoc($conexion->query("SELECT COUNT(Id_persona) as Nro FROM integrantes_semilla WHERE id_semilla = $Semilla AND Id_persona = ".$Id_usuario));
	$Nro = $R['Nro'];
	
	if ($Nro == 0) {
		$Insertar = "INSERT INTO integrantes_semilla (Id_persona, id_semilla, Fecha, Estado) VALUES ($Id_usuario, $Semilla, '$Fecha', 1)";

		if ($conexion -> query ($Insertar) ) {
			$Estado = 1;
			
		}else{
			$Estado = $Insertar;
		}
		
	}else{
		$Estado = 0;
	}

	return $Estado;
}

function ValorMETA($Sem, $ValorMeta){
	require 'conexion.php';

    date_default_timezone_set('america/bogota');
	$Fecha = date ("Y-m-d H:i:s");

	
	$Actualizar = "UPDATE metas_semilla set Valor_meta = $ValorMeta WHERE id_semilla = $Sem";
	if ($conexion -> query ($Actualizar)) {
		$ActPrinci = "UPDATE conformacion_semilla set Ultima_modificacion = '$Fecha' WHERE id_semilla = $Sem";
		if ($conexion -> query ($ActPrinci)) {
			$Estado = 1 ; 
		}else{
			$Estado = 0 ;
		}
	}else{
		$Estado = $Insertar;
	}
		
	
	return $Estado;
}
