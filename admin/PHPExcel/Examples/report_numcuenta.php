<?php
 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/Bogota');

require 'conexion.php';
$consulta_mysql1="SELECT uuu.Name, iss.Id_persona, IFNULL(inf.NroCuenta, 'No tiene registrado') NumeroCuenta, cns.Nombre_Semilla, IFNULL(inf.TipoCuenta, 'No tiene registrado') TipoCuenta, cns.Fecha_Creacion, cns.FechaCierre FROM integrantes_semilla iss INNER JOIN usuario uuu on uuu.Id_usuario = iss.Id_persona LEFT JOIN info_usuarios inf on inf.Id_usuario = iss.Id_persona INNER JOIN conformacion_semilla cns on cns.Id_Semilla = iss.Id_semilla";
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
							 ->setTitle("Numero y tipo de cuenta por asociado")
							 ->setSubject("Reportes")
							 ->setDescription("Numero y tipo de cuenta por asociado.")
							 ->setKeywords("Mensual")
							 ->setCategory("Reportes");


$objPHPExcel->setActiveSheetIndex(0) 
        ->setCellValue('B1', 'Nombre asociado') 
        ->setCellValue('C1', 'No de identidad')
        ->setCellValue('D1', 'No de cuenta')
        ->setCellValue('E1', 'Nombre de la semilla')
        ->setCellValue('F1', 'Tipo de cuenta')
        ->setCellValue('G1', 'Fecha de inicio de la Semilla')
        ->setCellValue('H1', 'Fecha de final de la Semilla');

$x=2; 
while ($row = $resorden1->fetch_assoc()){
        
	$objPHPExcel->setActiveSheetIndex(0) 
        ->setCellValue('B'.$x, $row['Name']) 
        ->setCellValue('C'.$x, $row['Id_persona']) 
        ->setCellValue('D'.$x, $row['NumeroCuenta']) 
        ->setCellValue('E'.$x, $row['Nombre_Semilla']) 
        ->setCellValue('F'.$x, $row['TipoCuenta']) 
        ->setCellValue('G'.$x, $row['Fecha_Creacion']) 
        ->setCellValue('H'.$x, $row['FechaCierre']);
$x++; 
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Numero y tipo de cuenta por asociado.xlsx"');
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
