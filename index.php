<?include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once 'vendor/autoload.php';
require_once 'Elements.php';
/*?><pre><?print_r($_SERVER)?></pre><?php*/

//CMain::IncludeFile('../vendor/autoload.php');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$cnt = 1;
$list = Elements::GetElems();
foreach ($list as $item){
	$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$drawing->setPath($item[6]);
	$drawing->setName('Image'  . $cnt);
	$drawing->setDescription('Image');
	$drawing->setWidth(80);
	$drawing->setCoordinates( 'G'.$cnt);
	$drawing->setWorksheet($sheet);
	/*?><pre><?print_r($item)?></pre><?php*/
	$sheet->setCellValue('A'.$cnt, $item[0]);
	$sheet->setCellValue('B'.$cnt, $item[1]);
	$sheet->setCellValue('C'.$cnt, $item[2]);
	$sheet->setCellValue('D'.$cnt, $item[3]);
	$sheet->setCellValue('E'.$cnt, $item[4]);
	$sheet->setCellValue('F'.$cnt, $item[5]);

	$sheet->setCellValue('H'.$cnt, $item[7]);
	$sheet->setCellValue('I'.$cnt, $item[8]);
	$sheet->setCellValue('J'.$cnt, $item[9]);
	$cnt++;
}
$writer = new Xlsx($spreadsheet);
$writer->save('hello world.xlsx');