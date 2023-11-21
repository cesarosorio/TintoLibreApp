<?php
error_reporting(0);

if(isset($_POST['nuevociclo'])){
    $Semilla = $_POST['Semilla'];
    $R=mysqli_fetch_assoc($conexion->query("SELECT Nombre_Semilla FROM conformacion_semilla WHERE Id_Semilla = ".$Semilla));
    $Nombre_Semilla = $R['Nombre_Semilla'];

    echo '<ol class="breadcrumb"> 
        <li class="breadcrumb-item">Menú de opciones.</li>
        <li class="breadcrumb-item">INFORMACIÓN DE MIS SEMILLAS.</li>
        <li class="breadcrumb-item active"><strong>Semilla: </strong>'.$Nombre_Semilla.'</li>
    </ol>

    <form method="POST" class="form-register" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Cargar documento masivo</label>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="form-group"> 
                <input class="form-control" type="file" name="documento" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
            </div>
        </div>
        <div class="col-md-12">
            <input type="hidden" name="Semilla" value="'.$Semilla.'">
            <input name="cargue_masivo" class="btn btn-dark btn-block" type="submit" value="¡Cargar!"/>
        </div>
    </div>
    </form>';

}

if(isset($_POST['cargue_masivo'])){
    $Semilla = $_POST['Semilla'];
    $R=mysqli_fetch_assoc($conexion->query("SELECT NombreOriginal FROM conformacion_semilla WHERE Id_semilla = $Semilla"));
    $NombreOriginal = $R['NombreOriginal'];
    $documento=$_FILES['documento']['name'];
	$tmpimagen=$_FILES['documento']['tmp_name'];
	$extimagen= pathinfo($documento); 
    // $rutasoporte= "Documentos/Ciclos/".rand(1, 500)."/"; 
    $rutasoporte= "Documentos/Ciclos/".$Semilla."/"; 

    if($_FILES["documento"]["error"]> 0 ){
		echo "Error al cargar los archivos";
	}else{
		 $permitidos = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		 $limite_kb = 5000;
		if(in_array($_FILES["documento"]["type"], $permitidos) && $_FILES["documento"]["size"] <= $limite_kb * 1024){
			$ruta_s = $rutasoporte;
			$documento = $ruta_s.$_FILES["documento"]["name"]; 
			if(!file_exists($ruta_s)){
				mkdir($ruta_s); 
			}
			if(!file_exists($documento)){
				$resultado_s = @move_uploaded_file($_FILES["documento"]["tmp_name"], $documento); 	
				if($resultado_s){
					
                    require 'PHPExcel/Classes/PHPExcel/IOFactory.php'; 				 
                    $nombreArchivo = $documento;
                    $objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
                    $objPHPExcel->setActiveSheetIndex(0);
                    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                    $FechaCr = date("Y-m-d");
                    $IngresoData = "INSERT INTO conformacion_semilla(Nombre_Semilla, NombreOriginal, Lider_Semilla, AporteSocial, Estado_Semilla, Fecha_Creacion, FechaCierre, TipoPago, ActaSemilla, Ultima_Modificacion, MontoPrestamo, minimo, maximo)(SELECT NombreOriginal Nombre_Semilla, NombreOriginal, Lider_Semilla, AporteSocial, 1, '$FechaCr' Fecha_Creacion, FechaCierre, TipoPago, ActaSemilla, NOW(), MontoPrestamo, minimo, maximo FROM conformacion_semilla WHERE Id_Semilla = $Semilla)";
                    
                    if($conexion->query($IngresoData)){

                        $conexion->query("UPDATE conformacion_semilla SET Estado_Semilla = '5', Ultima_Modificacion = '$FechaCr' WHERE Id_Semilla = $Semilla");

                        $R=mysqli_fetch_assoc($conexion->query("SELECT MAX(Id_Semilla) NID FROM conformacion_semilla WHERE NombreOriginal = '$NombreOriginal'"));
                        $SemillaCiclo = $R['NID'];
                        
                        for($i = 2; $i <= $numRows; $i++){
    
                            $CodSemilla = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(); 
                            $CodPersona = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(); 
                            $Continua = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue(); 
                            $Fondo= $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(); 
                            $Aporte = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
                            $Multa = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue(); 
                            $ValorEntregado = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(); 
                            $SaldoActual = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue(); 
 
                            $conexion->query("INSERT INTO semillas_terminadas(Id_semilla, Id_persona, Valor, Fecha, Ingresa) VALUES ($Semilla, $CodPersona, $ValorEntregado, NOW(), '$User')");

                            $Consulta = "SELECT * FROM integrantes_semilla WHERE Id_semilla = $Semilla and Id_persona = $CodPersona;";
                            $Resultado = $conexion->query($Consulta);
                            $CantDatos = mysqli_num_rows($Resultado);
                            $R=mysqli_fetch_assoc($Resultado);
                            
                            if($CantDatos > 0 AND $Continua == 'SI' ){
                                $Rol = $R['Rol'];
                                $Meta_personal = $R['Meta_personal'];
                                $conexion->query("INSERT INTO integrantes_semilla(Id_semilla, Id_persona, Rol, Meta_personal, Fecha, FechaFinalizacion, Estado) VALUES ($SemillaCiclo, $CodPersona, $Rol, $Meta_personal, '$FechaCr', NULL, 1)");
                            } 
                            if($SaldoActual != 0 ){
                                $conexion->query("INSERT INTO mv_meta_semilla(Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Prestamo) VALUES ($SemillaCiclo, $CodPersona, $SaldoActual, $Fondo, 'Movimiento automatico ciclo nuevo', '$FechaCr', NOW(), 'Sin comprobante', NULL)");
                            }
                            if($Multa != 0){

                                $Consulta = "SELECT * FROM multas_semilla WHERE Id_semilla = $SemillaCiclo AND NombreMulta = 'Multa por migración' AND Valor_Multa = $Multa ";
                                $Resultado = $conexion->query($Consulta);
                                $CantDatos = mysqli_num_rows($Resultado);

                                $R=mysqli_fetch_assoc($conexion->query("SELECT Id FROM mv_meta_semilla WHERE Id_usuario = $CodPersona AND Id_semilla = $SemillaCiclo AND Valor = $SaldoActual "));
                                $Id_mvto = $R['Id'];
                                

                                if($CantDatos == 0){
                                    $conexion -> query("INSERT INTO multas_semilla (Id_semilla, Presidente, NombreMulta, ObserMultas, Valor_Multa, Fecha_Creacion, Estado) VALUES ($SemillaCiclo, $User, 'Multa por migración', 'Multa generada automaticamente', $Multa, '$FechaCr', 1)");
                                    $R=mysqli_fetch_assoc($conexion->query("SELECT Id FROM multas_semilla WHERE Id_semilla = $SemillaCiclo AND NombreMulta = 'Multa por migración' AND Valor_Multa = $Multa "));
                                    $IdMulta = $R['Id'];
                                }else{
                                    $IdMulta = $Resultado['Id'];
                                }

                                $conexion->query("INSERT INTO mv_multa_semilla(Id_semilla, Id_presidente, Id_mvto, Id_multa, Valor_multa, Fecha, Estado, Prestamos) VALUES ($SemillaCiclo, $User, $Id_mvto, $IdMulta, $Multa, NOW(), 1, NULL)");

                            }
                            if($Aporte != 0){

                                $Consulta = "SELECT * FROM multas_semilla WHERE Id_semilla = $SemillaCiclo AND NombreMulta = 'Otras deducciones' AND Valor_Multa = $Multa ";
                                $Resultado = $conexion->query($Consulta);
                                $CantDatos = mysqli_num_rows($Resultado);

                                $R=mysqli_fetch_assoc($conexion->query("SELECT Id FROM mv_meta_semilla WHERE Id_usuario = $CodPersona AND Id_semilla = $SemillaCiclo AND Valor = $SaldoActual "));
                                $Id_mvto = $R['Id'];
                                

                                if($CantDatos == 0){
                                    $conexion -> query("INSERT INTO multas_semilla (Id_semilla, Presidente, NombreMulta, ObserMultas, Valor_Multa, Fecha_Creacion, Estado) VALUES ($SemillaCiclo, $User, 'Otras deducciones', 'Valor que se cobra de forma mensual a cada Asociado/a por afiliacion a TintoLibre', $Multa, '$FechaCr', 1)");
                                    $R=mysqli_fetch_assoc($conexion->query("SELECT Id FROM multas_semilla WHERE Id_semilla = $SemillaCiclo AND NombreMulta = 'Otras deducciones' AND Valor_Multa = $Multa "));
                                    $IdMulta = $R['Id'];
                                }else{
                                    $IdMulta = $Resultado['Id'];
                                }

                                $conexion->query("INSERT INTO mv_multa_semilla(Id_semilla, Id_presidente, Id_mvto, Id_multa, Valor_multa, Fecha, Estado, Tipo) VALUES ($SemillaCiclo, $User, $Id_mvto, $IdMulta, $Multa, NOW(), 1, 3)");

                            }

                            ?><script languaje="javascript">
                                alert("¡Se llevo con éxito todas las migraciones!");
                                window.location.href="../../admin/index.php?contenido=detSemilla&Semilla=<?php echo $SemillaCiclo ?>"; 
                            </script><?php
    
                        }
                    }else{
                        echo "<div class='container'><div class='alert alert-danger alert-dismissible'>No se pudo migrar la información de la semilla.</div>";
                    }
				}else{
					echo "<div class='container'><div class='alert alert-danger alert-dismissible'>No actualizo el anterior registro.</div>";
				}

			}else{
				echo "<div class='container'><div class='alert alert-danger alert-dismissible'>Ups, parece que ya existe el archivo, comunicate con el personal del departamento de sistemas.</div>";
			}
				
		}else{
			echo "<div class='container'><div class='alert alert-dark alert-dismissible'>El archivo supera el limite establecido o es un archivo no admitido.</div>";
		}
	} 

}