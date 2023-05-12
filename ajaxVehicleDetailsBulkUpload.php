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
$sheet->setCellValue('C1', 'Vehicle Name');
$sheet->setCellValue('D1', 'Vehicle Number');
$sheet->setCellValue('E1', 'Date Of Purchase');
$sheet->setCellValue('F1', 'Fitment Upto');
$sheet->setCellValue('G1', 'Insurance Upto');
$sheet->setCellValue('H1', 'Asset Value');
$sheet->setCellValue('I1', 'Book Value As On');

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

$sheet->getStyle('E2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');
$sheet->getStyle('F2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');
$sheet->getStyle('G2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');

$writer = new Xlsx($spreadsheet);
$writer->save('uploads/downloadfiles/vehicledetailsbulksample.xlsx');

?>