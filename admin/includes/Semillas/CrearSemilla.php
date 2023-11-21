<?php 

if (isset($_POST['Crear'])) {
	
	require '../conexion.php';
	$NomSemilla = $_POST['NomSemilla'];
	$LiderSemilla = $_POST['LiderSemilla'];
	$Estado = 1; 
	$aportesocial = $_POST['aportesocial'];
	$Comprobante = $_FILES['Acta']; 
	$FechaCierre = $_POST['FechaCierre'];
	$minimo = $_POST['minimo'];
	$maximo = $_POST['maximo'];

	$TipoPago=0;

	if (isset($_POST['check2'])) {
		$TipoPago = $_POST['check2'];
		$mesmaximo = $_POST['mesmaximo'];
		$quimaximo = 0;
		$quimaxidos = 0;
	}elseif(isset($_POST['check1'])){
		$TipoPago = $_POST['check1'];
		$quimaximo = $_POST['quimaximo'];
		$quimaxidos = $_POST['quimaxidos'];
		$mesmaximo = 0;
	}

	$MontoPrestamo = $_POST['MontoPrestamo'];
	$MultaPagoTarde = $_POST['MultaPagoTarde'];
	$Presidente = $_POST['Presidente'];

	$Buscar="SELECT COUNT(Nombre_semilla) AS Dato FROM conformacion_semilla WHERE Nombre_semilla = '$NomSemilla'";
	$siguiente=$conexion->query($Buscar);
    $final=mysqli_fetch_assoc($siguiente);
    $Dato=$final['Dato'];
 
    if ($Dato != 0) {
		$Estado=0;
	}else{ 
		if($Comprobante['error'] > 0){
			$Estado = 0; 
		}else{
			
			$permitidos = array("application/pdf", "image/jpeg", "image/png");

			if(in_array($Comprobante['type'], $permitidos)){

			    $ruta_a = "../../Documentos/ActasSemillas/".$NomSemilla."/"; 
			    $ruta_dcto = $ruta_a.$Comprobante['name']; 

			    if(!file_exists($ruta_a)){
			        mkdir($ruta_a); 
			    }

			    if(!file_exists($ruta_dcto)){
			    $resultado_a = @move_uploaded_file($Comprobante['tmp_name'], $ruta_dcto); 

			        if($resultado_a){
 		        		date_default_timezone_set('America/Bogota');
						$Fecha = date("Y-m-d");
						
						if ($aportesocial == NULL) {
							$aportesocial = 0;
						}
						 			             
			            $RegistrarSemilla="INSERT INTO conformacion_semilla (Nombre_semilla, NombreOriginal, Lider_semilla, aportesocial, TipoPago, MontoPrestamo, ActaSemilla, Estado_Semilla, Fecha_creacion, FechaCierre, minimo, maximo) VALUES ('$NomSemilla', '$NomSemilla', '$LiderSemilla', $aportesocial, $TipoPago, $MontoPrestamo, '$ruta_dcto', $Estado, '$Fecha', '$FechaCierre', $minimo, $maximo)";

						if ($conexion -> query ($RegistrarSemilla)) {
							if ($MultaPagoTarde != 0) {
								$Fe=DATE("Y-m-d");
								$Buscar="SELECT Id_semilla  FROM conformacion_semilla WHERE Nombre_semilla = '$NomSemilla'";
								$siguiente=$conexion->query($Buscar);
							    $final=mysqli_fetch_assoc($siguiente);
							    $Id_semilla=$final['Id_semilla'];

							    $AggMulta = "INSERT INTO multas_semilla (Id_semilla, Presidente, NombreMulta, ObserMultas, Valor_Multa, Fecha_creacion, Estado) VALUES ($Id_semilla, '$Presidente', 'Pago tarde', 'Multa creada por subir el comprobante tarde', $MultaPagoTarde, '$Fe', 1)";
								$conexion -> query ($AggMulta); 
							}
							
							$conexion -> query ("INSERT INTO diasparapago (Id_semilla, quimaximo, quimaxidos, mesmaximo) VALUES ($Id_semilla, $quimaximo, $quimaxidos, $mesmaximo)");

							?><script languaje="javascript">
								window.location="../../?contenido=viewSemilla";
								alert("¡Se creo con exito la semilla!");
							</script><?php 
							
						}else{
							?><script languaje="javascript">
								window.location="../../?contenido=viewSemilla";
								alert("¡Ups! algo ocurrio, prueba nuevamente");
							</script><?php 
						}

					} // Si es correcto gud 

		        }else{
		            ?><script languaje="javascript">
						window.location="../../?contenido=viewSemilla";
						alert("¡Ups! algo ocurrio, prueba nuevamente");
					</script><?php 
		        } //Valida si se sube o no

		    }else{
		        ?><script languaje="javascript">
					window.location="../../?contenido=viewSemilla";
					alert("¡Ups! algo ocurrio, prueba nuevamente");
				</script><?php 
		    } // Cierre de Validaciones tamaño y tipo

		}  // Cierre de errores

	} // Cierre de las validaciones 0
 
} // Cierra la funcion