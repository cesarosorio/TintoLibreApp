<?php 

include 'conexion.php';

if (isset($_POST['Alertar'])) {
	$Sem = $_POST['Semilla'];
	$Mvto = $_POST['Mvto'];
	$User = $_POST['Notifica'];
	$Observaciones = $_POST['Observaciones'];
 

	$R=mysqli_fetch_assoc($conexion->query("SELECT cs.Nombre_Semilla, cs.Lider_semilla, u.Name, u.Correo FROM conformacion_semilla cs inner join usuario u on u.Id_usuario = cs.Lider_Semilla WHERE id_semilla = ".$Sem)); 
	$Nombre_Semilla = $R['Nombre_Semilla'];
	$Lider_semilla = $R['Lider_semilla'];
	$Correo = $R['Correo'];
	$Name = $R['Name'];

	$aggal = "INSERT INTO alertas(Id_semilla, Id_mvto, Id_notifica, Observaciones, Fecha, Estado) VALUES ($Sem, $Mvto, $User, '$Observaciones', NOW(), 1)";
	if($conexion -> query($aggal)){
		?><script languaje="javascript">
	        window.location="../index.php?contenido=dwcomprobante";
	        alert("¡Excelente, se emitió la alerta!");
		</script><?php
	}else{
		?><script languaje="javascript">
	        window.location="../index.php?contenido=dwcomprobante";
	        alert("¡Ups, algo ocurrio, intenta de nuevo en un rato!");
		</script><?php
	}
}

if (isset($_POST['Modificar'])) {

	$idmvto = $_POST['Mvto'];
	$Observaciones = $_POST['Observaciones'];
	$Valor = $_POST['Valor'];
	$AporteSocial = $_POST['AporteSocial']; 
	$idprest = $_POST['idprest']; 
	$nmultas = $_POST['nmultas'];

	for ($i=1; $i <= $nmultas ; $i++) { 
		
		$id_multa = $_POST['idmulta'.$i];
		$MV=mysqli_fetch_assoc($conexion->query("SELECT Valor_multa	FROM mv_multa_semilla WHERE id = ".$id_multa));

		if ($MV['Valor_multa'] != $_POST['Valor_multa'.$i]) {
			$guarreg = $conexion->query("INSERT INTO multas_eliminadas (id, Id_semilla, Id_presidente, Id_mvto, Id_multa, Valor_multa, Fecha, Estado, Prestamos, Fecha_eli) (SELECT id, Id_semilla, Id_presidente, Id_mvto, Id_multa, Valor_multa, Fecha, Estado, Prestamos, NOW() FROM mv_multa_semilla WHERE id = $id_multa)");
			
			if ($_POST['Valor_multa'.$i] == 0) {
				$Eliminar = $conexion->query("DELETE FROM mv_multa_semilla WHERE Id = $id_multa");
			}else{
				$Actualizar = $conexion->query("UPDATE mv_multa_semilla SET Valor_multa = ".$_POST['Valor_multa'.$i]." WHERE Id = $id_multa");
			}
		} 
	}

	if ($idprest != NULL) {

		$Capital = $_POST['Capital'];
		$Intereses = $_POST['Intereses'];
		
		$MV=mysqli_fetch_assoc($conexion->query("SELECT Capital, Intereses FROM mv_multa_semilla WHERE id = ".$idprest));

		if ($Capital != $MV['Capital'] OR $Intereses != $MV['Intereses']) {

			$guarcamb = $conexion -> query("INSERT INTO mv_prestamos_sem_camb (Id, Id_prestamo, Id_semilla, Id_mvto, Capital, Intereses, Fecha, Fecha_camb) (SELECT Id, Id_prestamo, Id_semilla, Id_mvto, Capital, Intereses, Fecha, NOW() FROM mv_prestamos_sem WHERE id = ".$idprest);

			if ($Capital == 0 AND $Intereses == 0) {
				$Eliminar = $conexion -> query("DELETE FROM mv_prestamos_sem WHERE id = ".$idprest);
			}else{
				$Actualizar = $conexion -> query("UPDATE mv_prestamos_sem SET Capital = $Capital, Intereses = $Intereses WHERE id = ".$idprest);
			}

		}
	}
 	
	$aggcambio = $conexion -> query("INSERT INTO mv_meta_semilla_cambios (Id, Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Prestamo, Fecha_camb, Tipo) (SELECT Id, Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Tipo, NOW(), 1 FROM `mv_meta_semilla` WHERE id = $idmvto)");

	$actPrinc = "UPDATE mv_meta_semilla SET Observaciones = '$Observaciones', Valor = $Valor, AporteSocial = $AporteSocial WHERE id = $idmvto ";
	if ($conexion -> query($actPrinc)) {
		 $uptalert = "UPDATE alertas SET Estado = 0 WHERE Id_mvto = $idmvto AND Estado = 1";
		 if ($conexion-> query($uptalert)) {
		 	?><script languaje="javascript">
		        window.location="../index.php?contenido=ver_alerta";
		        alert("¡Excelente! Se atendió la alerta");
			</script><?php		
		 }else{
		 	?><script languaje="javascript">
	        	window.location="../index.php?contenido=ver_alerta";
		        alert("¡Se actualizo, pero ocurrio algo ...!");
			</script><?php		
		 }
	}else{
		?><script languaje="javascript">
	        window.location="../index.php?contenido=ver_alerta";
	        alert("¡Ups, algo ocurrio, intenta de nuevo en un rato!");
		</script><?php		
	}


}

if (isset($_POST['Eliminar'])) {
	$Mvto = $_POST['Mvto'];

	$aggcambio = $conexion -> query("INSERT INTO mv_meta_semilla_cambios (Id, Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Prestamo, Fecha_camb, Tipo) (SELECT Id, Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Prestamo, NOW(), 2 FROM `mv_meta_semilla` WHERE id = $Mvto)");

	$elprin = "DELETE FROM mv_meta_semilla WHERE Id = $Mvto";
	if ($conexion->query($elprin)) {
		$uptalert = "UPDATE alertas SET Estado = 0 WHERE Id_mvto = $Mvto AND Estado = 1";
		 if ($conexion-> query($uptalert)) {
		 	?><script languaje="javascript">
		        window.location="../index.php?contenido=ver_alerta";
		        alert("¡Excelente! Se atendió la alerta");
			</script><?php		
		 }else{
		 	?><script languaje="javascript">
	        	window.location="../index.php?contenido=ver_alerta";
		        alert("¡Se actualizo, pero ocurrio algo ...!");
			</script><?php		
		 }	
	}else{
		echo "error ".$elprin;
		?><script languaje="javascript">
	        // window.location="../index.php?contenido=ver_alerta";
	        alert("¡Ups, algo ocurrio, intenta de nuevo en un rato!");
		</script><?php		
	}


}
