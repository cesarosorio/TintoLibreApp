<?php 

require 'conexion.php'; 
date_default_timezone_set('america/bogota');
$Fecha_carga = date ("Y-m-d H:i:s"); 

if (isset($_POST['IngresarComprobante'])) {

	$Semilla = $_POST['Lider']; 
	$User = $_POST['AUser'];
	$MesActual = Date("m");
	$CuotaPrestamo = (!isset($_POST['CuotaPrestamo']) ) ? $_POST['CuotaPrestamo'] : 0 ;
	
	$ContarAportes = "SELECT COUNT(id_semilla) as Consig FROM mv_meta_semilla WHERE id_semilla = $Semilla AND Id_usuario = $User AND MONTH(Fecha_cp) = $MesActual ";
	$LeerSemilla = $conexion -> query ($ContarAportes);
	$R = mysqli_fetch_assoc ($LeerSemilla);
	$Consig = $R['Consig']; 

	$VerSemilla = "SELECT c.aportesocial, c.TipoPago FROM conformacion_semilla c WHERE c.id_semilla = $Semilla";
	$LeerSemilla = $conexion -> query ($VerSemilla);
	$R = mysqli_fetch_assoc ($LeerSemilla);
	$TipoPago = $R['TipoPago']; 
     
    $aportesocial = ($Consig == 0) ? $R['aportesocial'] : 0;
	
    $VerSemilla = "SELECT MAX(Id)+1 as MVTO FROM mv_meta_semilla";
	$LeerSemilla = $conexion -> query ($VerSemilla);
	$R = mysqli_fetch_assoc ($LeerSemilla);
	$Mvto = $R['MVTO']; 

	require 'AjustesMovimiento.php';
	$Ajuste = new Ajuste;
	$Multa = $Ajuste->multas($Semilla, $TipoPago);
	
 	$Prestamo = $Ajuste->prestamo($Semilla, $User, $CuotaPrestamo, $Mvto);

	$Valor_Multa = ($Multa['Multa'] == 1 ) ? $Multa['ValMulta'] : 0 ;
	
	$RestarValor = 0; 

	$Observaciones = ($_POST['Observaciones'] == NULL) ? 'No hay observaciones' : $_POST['Observaciones'];
	
	$Valor = $_POST['Valor'];
	$Fecha = $_POST['Fecha'];
	$Comprobante = $_FILES['Comprobante'];

   	$NuevoValor = $Valor - $aportesocial - $RestarValor - $Valor_Multa - $Prestamo;
	$Documento=$Comprobante['name'];
    $tmpimagen=$Comprobante['tmp_name'];
    $extimagen= pathinfo($Documento);

 	if($Comprobante['error'] > 0){         
        $Estado = 0;  
    }else{ 

	    $permitidos = array("application/pdf", "image/jpeg", "image/png"); 
	        if (in_array($Comprobante['type'], $permitidos)){

			$ruta_a = "../../Documentos/Comprobantes/".$Semilla."-".$Mvto."/"; 
			$ruta_dcto = $ruta_a.$Comprobante['name']; 

	        if(!file_exists($ruta_a)){
		        mkdir($ruta_a); 
	        }

	        if(!file_exists($ruta_dcto)){
	        $resultado_a = @move_uploaded_file($Comprobante['tmp_name'], $ruta_dcto); 

	            if($resultado_a){
	                 
	                $QueryInformacion="INSERT INTO mv_meta_semilla (id_semilla, Id_usuario, Valor, aportesocial, Observaciones, Fecha, Fecha_cp, Comprobante, Tipo) VALUES ($Semilla, $User, $NuevoValor, $aportesocial, '$Observaciones', '$Fecha', NOW(), '$ruta_dcto', 2)";

	                if ($conexion ->query($QueryInformacion)) {  
	                	$FecMulta=Date("Y-m-d");
	                	if ($Multa['Multa'] == 1) {
	                		$Presidente = $Multa['Presidente'];
	                		$Id_Multa = $Multa['Id_Multa'];
							$AgMulta = "INSERT INTO mv_multa_semilla (id_semilla, Id_presidente, Id_mvto, Id_Multa, Valor_Multa, Fecha, Estado) VALUES ($Semilla, $Presidente, $Mvto, $Id_Multa, $Valor_Multa, '$FecMulta', 1)";
							$conexion -> query($AgMulta);
						}

	                	$ValMeta = "SELECT cs.Nombre_Semilla, cs.id_semilla, (SELECT SUM(mv.Valor) FROM mv_meta_semilla mv WHERE mv.id_semilla = cs.id_semilla AND mv.Id_usuario = $User) as Ahorro, (SELECT iss.Meta_personal FROM integrantes_semilla iss WHERE iss.id_semilla = cs.id_semilla AND iss.Id_persona = $User) as Meta FROM conformacion_semilla cs WHERE cs.id_semilla = $Semilla AND cs.Estado_Semilla IN (1, 2)";
						$LVMeta = $conexion -> query ($ValMeta);
						$R = mysqli_fetch_assoc ($LVMeta);
						$Val = ($R['Ahorro'] < $R['Meta']) ? $EstaMeta = 0 : $EstaMeta = 1 ;
							
	                	$ActPrincp = "UPDATE conformacion_semilla SET Ultima_Modificacion = NOW() WHERE id_semilla = $Semilla";
	                	if ($conexion -> query($ActPrincp)) {

	                		if ($EstaMeta == 1) {
								// $conexion->query("UPDATE integrantes_semilla SET FechaFinalizacion = NOW(), Estado = 2 WHERE id_semilla = $Semilla AND Id_persona = $User");
								?><script languaje="javascript">
									window.location="../../?contenido=verpsemillas";
									alert("!Felicidades 💪 cumpliste con éxito tu meta!");
								</script><?php 
							}else{ 
		                		?><script languaje="javascript">
									window.location="../../?contenido=dwcomprobante";
									alert("¡Se cargo con éxito el comprobante!");
								</script><?php 
							} 
	                	}else{
	                		?><script languaje="javascript">
								window.location="../../?contenido=upcomprobante";
								alert("¡Ups, ocurrio un error, intenta de nuevo!");
							</script><?php 
	                	}
	                }else{
	                    ?><script languaje="javascript">
							window.location="../../?contenido=upcomprobante";
							alert("¡Ups, ocurrio un error, intenta de nuevo!");
						</script><?php
	                }
	            }else{
	                ?><script languaje="javascript">
						window.location="../../?contenido=upcomprobante";
						alert("¡Ups, ocurrio un error, intenta de nuevo!");
					</script><?php
	            }
	        }else{
	            ?><script languaje="javascript">
					window.location="../../?contenido=upcomprobante";
					alert("¡Ups, ocurrio un error, intenta de nuevo!");
				</script><?php
	        } 
	    }else{
	    	?><script languaje="javascript">
				window.location="../../?contenido=upcomprobante";
				alert("¡Ups, ocurrio un error, intenta de nuevo!");
			</script><?php
	    }
	} // Cierre de las validaciones 0 

} // Cierre del final de la funcion
