<?php
 /*
 You can use XLSX2CSV very easily as shown below, just change the paths to the correct paths you need.
 
 */
require_once __DIR__ . '/vendor/autoload.php'; 

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$spreadsheet = $reader->load("dataSets/DATA RUMAH.xlsx");

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
$writer->save("dataSets/dataRumah.csv");

?>