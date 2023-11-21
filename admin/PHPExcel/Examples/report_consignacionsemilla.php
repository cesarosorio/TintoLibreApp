<?php
 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');

$Anio = $_POST['Anio'];
$Mes = $_POST['Mes'];

require 'conexion.php';
$consulta_mysql1="SELECT cs.Nombre_Semilla, (SELECT CASE WHEN SUM(Valor+AporteSocial) IS NULL THEN 0 ELSE SUM(Valor+AporteSocial) END FROM mv_meta_semilla WHERE Id_semilla = cs.Id_Semilla ) as General, (SELECT CASE WHEN SUM(Valor+AporteSocial) IS NULL THEN 0 ELSE SUM(Valor+AporteSocial) END FROM mv_meta_semilla WHERE Id_semilla = cs.Id_Semilla AND YEAR(Fecha) = $Anio AND MONTH(Fecha) = $Mes) as Mes FROM conformacion_semilla cs;";
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
							 ->setTitle("Total ahorrado por semilla")
							 ->setSubject("Reportes")
							 ->setDescription("Total ahorrado por semilla.")
							 ->setKeywords("Mensual")
							 ->setCategory("Reportes");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Semilla') 
            ->setCellValue('B1', 'General')
            ->setCellValue('C1', 'Mes');

$x=2;

while ($row = $resorden1->fetch_assoc()){

	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$x, $row['Nombre_Semilla'])
	            ->setCellValue('B'.$x, $row['General']) 
	            ->setCellValue('C'.$x, $row['Mes']);
        $x++;
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Total Ahorrado Semillas.xlsx"');
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
