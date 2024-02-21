<?php 
 
include '../conexion.php';

if (isset($_POST['cessem'])) {
    $Sem = $_POST['Semilla'];
    $Estado_Semilla = $_POST['Estado_Semilla'];

    if($Estado_Semilla == 4) 
        $Fragmento = "Nombre_Semilla = CONCAT(Nombre_Semilla, ' (Ciclo ', CURDATE(), ')'),";
    else
        $Fragmento = "";

    $Actualizar = "UPDATE conformacion_semilla SET $Fragmento Estado_Semilla = '$Estado_Semilla' WHERE id_semilla = $Sem";
    if ($conexion -> query ($Actualizar)) {
        $ActPrinci = "UPDATE conformacion_semilla SET Ultima_modificacion = NOW() WHERE id_semilla = $Sem ";
        if ($conexion -> query ($ActPrinci)) { ?>
            <script languaje="javascript">
                alert("¡Se modifico con éxito el estado de la semilla!");
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>"; 
            </script>
        <?php }else{ echo $ActPrinci; ?>
            <script languaje="javascript">
                alert("¡Por favor, intente de nuevo!");
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>"; 
            </script>
        <?php }
    }else{ echo $Actualizar; ?>
        <script languaje="javascript">
            alert("¡Por favor, intente de nuevo!");
            window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>";
        </script>
    <?php } 
    
}

if (isset($_POST['aggp'])) {
    
    $Id_usuario = $_POST['Id_usuario'];
    $Semilla = $_POST['Semilla'];

    $R=mysqli_fetch_assoc($conexion->query("SELECT COUNT(Id_persona) as Nro FROM integrantes_semilla WHERE id_semilla = $Semilla AND Id_persona = ".$Id_usuario));
    $Nro = $R['Nro'];
    
    if ($Nro == 0) {
        $Insertar = "INSERT INTO integrantes_semilla (Id_persona, id_semilla, Fecha, Estado) VALUES ($Id_usuario, $Semilla, NOW(), 1)";

        if ($conexion -> query ($Insertar) ) {
        
        	$S=mysqli_fetch_assoc($conexion->query("select nombre_semilla from conformacion_semilla where id_semilla = ".$Semilla));
	$nombre_semilla = $S['nombre_semilla'];
	
	$C=mysqli_fetch_assoc($conexion->query("SELECT Name, case when Correo is null then 'No' else Correo end as Correo FROM usuario WHERE id_usuario = ".$Id_usuario));
	$Correo = $C['Correo'];
	$Name = $C['Name'];
				if($Correo != 'No'){
			    
$cabeceras = 'From: admin@tusemilla.com.co';
$asunto = utf8_decode("¡Ya puedes acceder a tu semilla ".utf8_decode($nombre_semilla)."!");
$mensaje="¡Hola ".utf8_decode($Name).", tu semilla ha sido creada de manera exitosa. 

Puedes acceder con tu usuario y contraseña a través de la página https://app.tusemilla.com.co.  De ahora en adelante todo lo relacionado con ahorro, solicitud y pago de préstamos, pago de multas y aporte al Fondo de Emergencia lo harán a través de la plataforma. 

Nota: Para poder ingresar haz clic sobre el link o copialo y pegalo en la barra del navegador.

Te dejamos 'a la mano' los datos de la cuenta bancaria donde permanecerá tu ahorro.

CUENTA BANCARIA

Banco Caja social Ahorro: 
# 241 1557 1664
TintoLibre
901.563.012-2

Te felicitamos por tener la valentía de ahorrar por tus sueños

Att: TintoLibre";
mail($Correo, $asunto, $mensaje, $cabeceras);
			    
}
        
        ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
                alert("¡Se creo con éxito el registro!");
            </script>
        <?php }else{ ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>";
                alert("¡Por favor, intente de nuevo!");
            </script>
        <?php }
    }else{ ?>
        <script languaje="javascript">
            // window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>";
            alert("¡Por favor, intente de nuevo!");
        </script>
    <?php }
}

if (isset($_POST['aggm'])) {

    $Sem = $_POST['Semilla'];
    $FechaCierre = $_POST['FechaCierre']; 
    $Nombre = $_POST['Nombre'];
    $aportesocial = $_POST['aportesocial'];
    $minimo = $_POST['minimo'];
    $maximo = $_POST['maximo']; 
    $montoPrestamo = $_POST['montoprestamo']; 

    $Actualizar = "UPDATE conformacion_semilla SET FechaCierre = '$FechaCierre', nombre_semilla = '$Nombre', aportesocial = $aportesocial, minimo = $minimo, maximo = $maximo, montoPrestamo = $montoPrestamo WHERE id_semilla = $Sem";
    if ($conexion -> query ($Actualizar)) {
        $ActPrinci = "UPDATE conformacion_semilla SET Ultima_modificacion = NOW() WHERE id_semilla = $Sem ";
        if ($conexion -> query ($ActPrinci)) { ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>";
                alert("¡Se modifico con éxito la fecha de cierre!");
            </script>
        <?php }else{ ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>";
                alert("¡Por favor, intente de nuevo!");
            </script>
        <?php }
    }else{ ?>
        <script languaje="javascript">
            window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Sem ?>";
            alert("¡Por favor, intente de nuevo!");
        </script>
    <?php } 

}


 if (isset($_POST['aggpp'])) {
    $Id_usuario = $_POST['Id_usuario'];
    $Semilla = $_POST['Semilla'];

    $R=mysqli_fetch_assoc($conexion->query("SELECT COUNT(Id_persona) as Nro FROM integrantes_semilla WHERE id_semilla = $Semilla AND Id_persona = ".$Id_usuario));
    $Nro = $R['Nro'];
    
    if ($Nro == 0) {
        $Insertar = "INSERT INTO integrantes_semilla (Id_persona, id_semilla, Fecha, Estado) VALUES ($Id_usuario, $Semilla, NOW(), 1)";

        if ($conexion -> query ($Insertar) ) {
            
            $S=mysqli_fetch_assoc($conexion->query("select nombre_semilla from conformacion_semilla where id_semilla = ".$Semilla));
        	$nombre_semilla = $S['nombre_semilla'];
        	
        	$C=mysqli_fetch_assoc($conexion->query("SELECT Name, case when Correo is null then 'No' else Correo end as Correo FROM usuario WHERE id_usuario = ".$Id_usuario));
        	$Correo = $C['Correo'];
        	$Name = $C['Name'];
if($Correo != 'No'){
			    
$cabeceras = 'From: admin@tusemilla.com.co';
$asunto = utf8_decode("¡Ya puedes acceder a tu semilla ".utf8_decode($nombre_semilla)."!");
$mensaje="¡Hola ".utf8_decode($Name).", tu semilla ha sido creada de manera exitosa. 

Puedes acceder con tu usuario y contraseña a través de la página https://app.tusemilla.com.co.  De ahora en adelante todo lo relacionado con ahorro, solicitud y pago de préstamos, pago de multas y aporte al Fondo de Emergencia lo harán a través de la plataforma. 

Nota: Para poder ingresar haz clic sobre el link o copialo y pegalo en la barra del navegador.

Te dejamos 'a la mano' los datos de la cuenta bancaria donde permanecerá tu ahorro.

CUENTA BANCARIA

Banco Caja social Ahorro: 
# 241 1557 1664
TintoLibre
901.563.012-2

Te felicitamos por tener la valentía de ahorrar por tus sueños

Att: TintoLibre";
mail($Correo, $asunto, $mensaje, $cabeceras);
			    
}
        
        ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=menu_mvsem"; 
                alert("¡Se creo con éxito el registro!");
            </script>
        <?php }else{ ?>
            <script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=menu_mvsem";
                alert("¡Por favor, intente de nuevo!");
            </script>
        <?php }
    }else{ ?>
        <script languaje="javascript">
            window.location.href="../../../admin/index.php?contenido=menu_mvsem";
            alert("¡Por favor, intente de nuevo!");
        </script>
    <?php }
} 

if(isset($_POST['upload_cierre'])){
    $Documento = $_FILES['documento'];
    $id_cierre = $_POST['id_cierre']; 
    $Semilla = $_POST['Semilla'];     
 
	// $Documento=$Documento['name'];
    // $tmpimagen=$Documento['tmp_name'];
    // $extimagen= pathinfo($Documento);

 	if($Documento['error'] > 0){         
        $Estado = 0;  
    }else{ 
	    $permitidos = array("application/pdf", "image/jpeg", "image/png"); 
        if (in_array($Documento['type'], $permitidos)){

        $ruta_a = "../../Documentos/Comprobantes_cierre/".$id_cierre."/"; 
        $ruta_dcto = $ruta_a.$Documento['name']; 

        if(!file_exists($ruta_a)){
            mkdir($ruta_a); 
        }

        if(!file_exists($ruta_dcto)){
            $resultado_a = @move_uploaded_file($Documento['tmp_name'], $ruta_dcto); 

            if($resultado_a){
                $ActualizaMvto = "UPDATE semillas_terminadas SET Comprobante = '$ruta_dcto' WHERE id = $id_cierre";
                if($conexion->query($ActualizaMvto)){
                    ?><script languaje="javascript">
                        window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
                        alert("¡Se cargo la información correctamente!");
                    </script><?php
                }else{
                    echo $ActualizaMvto;
                    ?><script languaje="javascript">
                        window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
                        alert("¡Ups, ocurrio un error, intenta de nuevo!");
                    </script><?php
                }
                
            }else{
                ?><script languaje="javascript">
                    window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
                    alert("¡Ups, ocurrio un error, intenta de nuevo!");
                </script><?php
            }
        }else{
            ?><script languaje="javascript">
                window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
                alert("¡Ups, ocurrio un error, intenta de nuevo!");
            </script><?php
        } 
    }else{
        ?><script languaje="javascript">
            window.location.href="../../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $Semilla ?>"; 
            alert("¡Ups, ocurrio un error, intenta de nuevo!");
        </script><?php
    }
} // Cierre de las validaciones 0 
}