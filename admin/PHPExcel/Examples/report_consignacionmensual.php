<?php
 
error_reporting(0);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');

$Anio = $_POST['Anio'];
$Mes = $_POST['Mes'];

require 'conexion.php';
$consulta_mysql1="SELECT ms.Fecha, u.NAME Persona, ms.Observaciones, ms.Id Movimiento, s.Nombre_Semilla Semilla, ms.Fecha_cp Fecha_sistema, CASE WHEN ms.tipo = 1 THEN 'Corregido' ELSE 'Eliminado' END AS Tipo, (ms.Valor) as Ahorro, (ms.AporteSocial) as Fondo_social, CASE WHEN mms.NombreMulta = 'Otras deducciones' THEN IFNULL(sum(mm.Valor_multa), 0) ELSE 0 END AS 'Aporte_fondo_mutual', CASE WHEN mms.NombreMulta != 'Otras deducciones' THEN IFNULL(sum(mm.Valor_multa), 0) ELSE 0 END AS 'Multas', IFNULL(mms.NombreMulta, 'No tiene multa') Tipo_multa, IFNULL(mps.Intereses, 0) InteresesPrestamo, IFNULL(mps.Capital, 0) CapitalPrestamo, 'No aplica' AS Comprobante FROM conformacion_semilla s INNER JOIN integrantes_semilla i on i.Id_semilla = s.Id_Semilla INNER JOIN usuario u on u.Id_usuario = i.Id_persona INNER JOIN mv_meta_semilla_cambios ms on ms.Id_semilla = s.Id_Semilla and ms.Id_usuario = u.Id_usuario LEFT JOIN mv_multa_semilla mm on mm.Id_mvto = ms.Id LEFT JOIN multas_semilla mms on mms.Id = mm.Id_multa LEFT JOIN mv_prestamos_sem mps on mps.Id_mvto = mm.Id_mvto WHERE YEAR(ms.Fecha) = $Anio AND MONTH(ms.Fecha) = $Mes GROUP BY u.Name, s.Nombre_Semilla, YEAR(ms.Fecha), MONTH(ms.Fecha), ms.Id

UNION ALL

SELECT ms.Fecha, u.NAME Persona, ms.Observaciones, ms.Id Movimiento, s.Nombre_Semilla Semilla, ms.Fecha_cp Fecha_sistema, 'Vigente' as Tipo, (ms.Valor) as Ahorro, (ms.AporteSocial) as Fondo_social, CASE WHEN mms.NombreMulta = 'Otras deducciones' THEN IFNULL(sum(mm.Valor_multa), 0) ELSE 0 END AS 'Aporte_fondo_mutual', CASE WHEN mms.NombreMulta != 'Otras deducciones' THEN IFNULL(sum(mm.Valor_multa), 0) ELSE 0 END AS 'Multas', IFNULL(mms.NombreMulta, 'No tiene multa') Tipo_multa, IFNULL(mps.Intereses, 0) InteresesPrestamo, IFNULL(mps.Capital, 0) CapitalPrestamo, CONCAT('https://app.tusemilla.com.co/admin/', SUBSTR(ms.Comprobante, 7)) AS Comprobante FROM conformacion_semilla s INNER JOIN integrantes_semilla i on i.Id_semilla = s.Id_Semilla INNER JOIN usuario u on u.Id_usuario = i.Id_persona INNER JOIN mv_meta_semilla ms on ms.Id_semilla = s.Id_Semilla and ms.Id_usuario = u.Id_usuario LEFT JOIN mv_multa_semilla mm on mm.Id_mvto = ms.Id LEFT JOIN multas_semilla mms on mms.Id = mm.Id_multa LEFT JOIN mv_prestamos_sem mps on mps.Id_mvto = mm.Id_mvto WHERE YEAR(ms.Fecha) = $Anio AND MONTH(ms.Fecha) = $Mes GROUP BY u.Name, s.Nombre_Semilla, YEAR(ms.Fecha), MONTH(ms.Fecha), ms.Id";
$resorden1 = mysqli_query($conexion, $consulta_mysql1);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("TintoLibre")
							 ->setLastModifiedBy("TintoLibre")
							 ->setTitle("Reporte de Consignacion Mensual")
							 ->setSubject("Reportes")
							 ->setDescription("Reporte de movimientos (sólamente los movimientos que han sido registrados durante ese mes, y mostrando también los que se hayan eliminados).")
							 ->setKeywords("Mensual")
							 ->setCategory("Reportes");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Reporte de Consignacion Mensual')
            ->setCellValue('A2', 'Fecha')
            ->setCellValue('B2', 'Persona')
            ->setCellValue('C2', 'Observaciones') 
            ->setCellValue('D2', 'Movimiento')
            ->setCellValue('E2', 'Semilla')
            ->setCellValue('F2', 'Fecha del sistema')
            ->setCellValue('G2', 'Tipo')
            ->setCellValue('H2', 'Ahorro neto de consignación ')
            ->setCellValue('I2', 'Fondo de emergencia')
            ->setCellValue('J2', 'Aporte fondo de emergencia asociacion mutual')
            ->setCellValue('K2', 'Multas')
            ->setCellValue('L2', 'Tipo multa')
            ->setCellValue('M2', 'Pago Intereses préstamo')
            ->setCellValue('N2', 'Pago Capital préstamo')
            ->setCellValue('O2', 'Total Ahorro') 
            ->setCellValue('P2', 'Comprobante');

$x=3; 

while ($row = $resorden1->fetch_assoc()){
 
	$Ahorro = $row['Ahorro']+$row['Fondo_social']+$row['Aporte_fondo_mutual']+$row['Multas']+$row['InteresesPrestamo']+$row['CapitalPrestamo'];

	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$x, $row['Fecha'])
        ->setCellValue('B'.$x, $row['Persona'])
        ->setCellValue('C'.$x, $row['Observaciones'])
        ->setCellValue('D'.$x, $row['Movimiento'])
        ->setCellValue('E'.$x, $row['Semilla'])
        ->setCellValue('F'.$x, $row['Fecha_sistema'])
        ->setCellValue('G'.$x, $row['Tipo'])
        ->setCellValue('H'.$x, $Ahorro)
        ->setCellValue('I'.$x, $row['Fondo_social'])
        ->setCellValue('J'.$x, $row['Aporte_fondo_mutual'])
        ->setCellValue('K'.$x, $row['Multas'])
        ->setCellValue('L'.$x, $row['Tipo_multa'])
        ->setCellValue('M'.$x, $row['InteresesPrestamo'])
        ->setCellValue('N'.$x, $row['CapitalPrestamo']) 
        ->setCellValue('P'.$x, $row['Comprobante']);
	$x++;
}


//set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte Mensual.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
