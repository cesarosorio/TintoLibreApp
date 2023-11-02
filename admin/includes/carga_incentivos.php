<?php

error_reporting(0);

if (isset($_POST['CargaMasiva'])) {

    $UserCarga = $_POST['CargaMasiva'];
    $documento = $_FILES['documento']['name'];
    $tmpimagen = $_FILES['documento']['tmp_name'];
    $extimagen = pathinfo($documento);
    $rutasoporte = "Documentos/Incentivos/" . rand(1, 10000) . "/";

    if ($_FILES["documento"]["error"] > 0) {
        echo "Error al cargar los archivos";
    } else {
        $permitidos = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        $limite_kb = 5000;
        if (in_array($_FILES["documento"]["type"], $permitidos) && $_FILES["documento"]["size"] <= $limite_kb * 1024) {
            $ruta_s = $rutasoporte;
            $documento = $ruta_s . $_FILES["documento"]["name"];
            if (!file_exists($ruta_s)) {
                mkdir($ruta_s);
            }
            if (!file_exists($documento)) {
                $resultado_s = @move_uploaded_file($_FILES["documento"]["tmp_name"], $documento);
                if ($resultado_s) {

                    require 'PHPExcel/Classes/PHPExcel/IOFactory.php';
                    $nombreArchivo = $documento;
                    $objPHPExcel = PHPEXCEL_IOFactory::load($nombreArchivo);
                    $objPHPExcel->setActiveSheetIndex(0);
                    $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                    for ($i = 2; $i <= $numRows; $i++) {

                        $Cedula = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                        $Semilla = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                        $Valor = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                        $Observacion = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue(); 

                        $conexion->query("INSERT INTO mv_meta_semilla(Id_semilla, Id_usuario, Valor, AporteSocial, Observaciones, Fecha, Fecha_cp, Comprobante, Tipo) VALUES ($Semilla, $Cedula, $Valor, 0, '$Observacion', NOW(), NOW(), 'No aplica', 1)");
                    }

                    ?><script languaje="javascript">
                        alert("¡Se llevo con éxito todas la carga de incentivos!");
                        window.location.href="../../admin/index.php?contenido=carga_incentivos"; 
                    </script><?php
                } else {
                    echo "<div class='container'><div class='alert alert-danger alert-dismissible'>No se pudo migrar la información de la semilla.</div>";
                }
            } else {
                echo "<div class='container'><div class='alert alert-danger alert-dismissible'>No actualizo el anterior registro.</div>";
            }
        } else {
            echo "<div class='container'><div class='alert alert-danger alert-dismissible'>Ups, parece que ya existe el archivo, comunicate con el personal del departamento de sistemas.</div>";
        }
    }
} else { ?>

    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Carga Masiva.</li>
    </ol>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="form-check">
                <label>Carga de incentivos masivos</label>
                <input class="form-control" type="file" name="documento" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
            </div>
        </div>


        <input type="hidden" name="CargaMasiva" value="<?php echo $User ?>">
        <input name="upload_cierre" class="btn btn-dark btn-block" type="submit" value="Subir Incentivos" />

    </form>

<?php }
