<?php 

include 'conexion.php';

if (isset($_POST['EnvRespuesta'])) {
	$EstadoPrestamo = $_POST['EstadoPrestamo']; 
	$intereses = $_POST['intereses']; 
	
	if ($EstadoPrestamo != 2) { 
		$intereses=0; 
	}
	
	$IdPres = $_POST['IdPres'];

	$ActResp = "UPDATE prestamos SET Estado = $EstadoPrestamo, intereses = $intereses, FechaRespuesta = NOW() WHERE Id = $IdPres";
	if ($conexion -> query($ActResp)) {
		?><script languaje="javascript">
            window.location="../index.php?contenido=viewprest";
            alert("¡Excelente, se envio la respuesta!");
    	</script><?php
	}else{ 
		?><script languaje="javascript">
            window.location="../index.php?contenido=viewprest";
            alert("¡Ups, ocurrio algo, intenta nuevamente!");
    	</script><?php
	}

}

if (isset($_POST['AcepPrestamo'])) {
	$IdPres = $_POST['IdPres'];

	$ActResp = "UPDATE prestamos SET Estado = 8, FechaRespuesta = NOW() WHERE Id = $IdPres";

	if ($conexion -> query($ActResp)) {
		?><script languaje="javascript">
            window.location="../index.php?contenido=menus_prestamos";
            alert("¡Excelente, se envio la respuesta!");
    	</script><?php
	}else{ 
		?><script languaje="javascript">
            window.location="../index.php?contenido=menus_prestamos";
            alert("¡Ups, ocurrio algo, intenta nuevamente!");
    	</script><?php
	}
	
}

if (isset($_POST['DesembolsarPrestamo'])) {

	$pres = $_POST['IdPres'];
	$Comprobante = $_FILES['Comprobante'];
	$Documento=$Comprobante['name'];
    $tmpimagen=$Comprobante['tmp_name'];
    $extimagen= pathinfo($Documento);

    //$Random = (rand(1, 100000));
     
    if($Comprobante['error'] > 0){         
        $Estado = 0;  
    }else{ 
	    $permitidos = array("application/pdf", "image/jpeg", "image/png");
 
	        if (in_array($Comprobante['type'], $permitidos) ){

	        $ruta_a = "../Documentos/Prestamos/".$pres."/"; 
	        $ruta_dcto = $ruta_a.$Comprobante['name']; 

	        if(!file_exists($ruta_a)){
		        mkdir($ruta_a); 
	        }

	        if(!file_exists($ruta_dcto)){
	        $resultado_a = @move_uploaded_file($Comprobante['tmp_name'], $ruta_dcto); 

	            if($resultado_a){ 

                	$ActPrincp = "UPDATE prestamos SET URLComprobante = '../".$ruta_dcto."', FechaPrestamo = NOW(), Estado = 6 WHERE Id = $pres";
                	if ($conexion -> query($ActPrincp)) {

						  	$R=mysqli_fetch_assoc($conexion->query("SELECT u.Name, u.Correo from prestamos p inner join usuario u on u.Id_usuario = p.Id_responsable WHERE p.id = $pres"));
      						$Responsable = $R['Name'];
      						$Correo = $R['Correo'];

      						if ($Correo != NULL) {
								$asunto = utf8_decode("¡Genial! El préstamo fue desembolsado");
								$cabeceras = 'From: admin@tusemilla.com.co';
								 $mensaje=utf8_decode("Lo valioso de la semilla es ayudarse entre todos, en esta oportunidad te informamos que han ayudado a la persona que solicitó el préstamo 💪. La mayoría de integrantes de tu semilla votaron por aprobar el préstamo, por esta razón ya fue desembolsado el dinero a quien lo solicitó.

¡Pronto verás los resultados de ahorrar en grupo!

Att: TintoLibre");
mail($Correo, $asunto, $mensaje, $cabeceras);


      							 
      						}

                		?><script languaje="javascript">
							window.location="../index.php?contenido=viewprest";
							alert("¡Se desembolso con exito!");
						</script><?php 
                	}else{
                		echo $ActPrincp; // No actulizo el principal 
                		?><script languaje="javascript">
							window.location="../index.php?contenido=viewprest";
							alert("¡Ups, ha ocurrido un error, intentalo de nuevo!");
						</script><?php  
	                }
	            }else{
	                ?><script languaje="javascript">
						window.location="../index.php?contenido=viewprest";
						alert("¡Ups, ha ocurrido un error, intentalo de nuevo!");
					</script><?php 
	            }
	        }else{
	            ?><script languaje="javascript">
					window.location="../index.php?contenido=viewprest";
					alert("¡Ups, ha ocurrido un error, intentalo de nuevo!");
				</script><?php 
	        } 
	    }else{
	    	?><script languaje="javascript">
				window.location="../index.php?contenido=viewprest";
				alert("¡Ups, ha ocurrido un error, intentalo de nuevo!");
			</script><?php 
	    }
	} // Cierre de las validaciones 0 
}