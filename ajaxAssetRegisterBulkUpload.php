<?php
@session_start();
include('ajaxconfig.php');
require 'excelvendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

$companyQry = "SELECT * FROM company_creation";
$companyresult = mysqli_query($con, $companyQry);

$branchQry = "SELECT * FROM branch_creation";
$branchresult = mysqli_query($con, $branchQry);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$sheet->setCellValue('A1', 'Company Name');
$sheet->setCellValue('B1', 'Branch Name');
$sheet->setCellValue('C1', 'Asset Classification');
$sheet->setCellValue('D1', 'Asset Name');
$sheet->setCellValue('E1', 'Date of Purchase');
$sheet->setCellValue('F1', 'Asset Nature');
$sheet->setCellValue('G1', 'Asset/Book Value');
$sheet->setCellValue('H1', 'Maintenance Required');
$data = [];
while ($row = $companyresult->fetch_assoc()) {
    $data[] = $row["company_name"];
}

for($i=2; $i<1000; $i++){
    $companyNameDropdown = $sheet->getCell('A'.$i)->getDataValidation();
    $companyNameDropdown->setType(DataValidation::TYPE_LIST);
    $companyNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $companyNameDropdown->setAllowBlank(false);
    $companyNameDropdown->setShowInputMessage(true);
    $companyNameDropdown->setShowErrorMessage(true);
    $companyNameDropdown->setShowDropDown(true);
    $companyNameDropdown->setFormula1('"'.implode(',', $data).'"');
}

$branchData = [];
while ($row1 = $branchresult->fetch_assoc()) {
    $branchData[] = $row1["branch_name"];
}

for($j=2; $j<1000; $j++){
    $branchNameDropdown = $sheet->getCell('B'.$j)->getDataValidation();
    $branchNameDropdown->setType(DataValidation::TYPE_LIST);
    $branchNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $branchNameDropdown->setAllowBlank(false);
    $branchNameDropdown->setShowInputMessage(true);
    $branchNameDropdown->setShowErrorMessage(true);
    $branchNameDropdown->setShowDropDown(true);
    $branchNameDropdown->setFormula1('"'.implode(',', $branchData).'"');
}

$sheet->getStyle('H2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');
$sheet->getStyle('J2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');

$writer = new Xlsx($spreadsheet);
$writer->save('uploads/downloadfiles/assetregisterbulksample.xlsx');

?>