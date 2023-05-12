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

$assetClassQry = "SELECT * FROM asset_register";
$assetClassresult = mysqli_query($con, $assetClassQry);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$sheet->setCellValue('A1', 'Asset Classification');
$sheet->setCellValue('B1', 'Company Name');
$sheet->setCellValue('C1', 'Branch Name');
$sheet->setCellValue('D1', 'Asset Name');
$sheet->setCellValue('E1', 'Asset Value');
$sheet->setCellValue('F1', 'As on Date Value');
$sheet->setCellValue('G1', 'Date of put to use');
$sheet->setCellValue('H1', 'Depreciation');
$sheet->setCellValue('I1', 'Model no');
$sheet->setCellValue('J1', 'Warranty Upto');
$sheet->setCellValue('K1', 'Spares Name');


// Data

$asset_class =  [
    'Plant & Machinary',
    'Land & Building',
    'Computer',
    'Printer and Scanner',
    'Furniture and Fixtures',
    'Electrical & fitting',
];

$assetClassDropdown = $sheet->getCell('A2')->getDataValidation();
$assetClassDropdown->setType(DataValidation::TYPE_LIST);
$assetClassDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$assetClassDropdown->setAllowBlank(false);
$assetClassDropdown->setShowInputMessage(true);
$assetClassDropdown->setShowErrorMessage(true);
$assetClassDropdown->setShowDropDown(true);
$assetClassDropdown->setFormula1('"'.implode(',', $asset_class).'"');


$data = [];
while ($row = $companyresult->fetch_assoc()) {
    $data[] = $row["company_name"];
}

$companyNameDropdown = $sheet->getCell('B2')->getDataValidation();
$companyNameDropdown->setType(DataValidation::TYPE_LIST);
$companyNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$companyNameDropdown->setAllowBlank(false);
$companyNameDropdown->setShowInputMessage(true);
$companyNameDropdown->setShowErrorMessage(true);
$companyNameDropdown->setShowDropDown(true);
$companyNameDropdown->setFormula1('"'.implode(',', $data).'"');


$branchData = [];
while ($row = $branchresult->fetch_assoc()) {
    $branchData[] = $row["branch_name"];
}

$branchNameDropdown = $sheet->getCell('C2')->getDataValidation();
$branchNameDropdown->setType(DataValidation::TYPE_LIST);
$branchNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$branchNameDropdown->setAllowBlank(false);
$branchNameDropdown->setShowInputMessage(true);
$branchNameDropdown->setShowErrorMessage(true);
$branchNameDropdown->setShowDropDown(true);
$branchNameDropdown->setFormula1('"'.implode(',', $branchData).'"');

$sheet->getStyle('G2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');
$sheet->getStyle('J2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');

$writer = new Xlsx($spreadsheet);
$writer->save('uploads/bulkimport/asset_details_format.xlsx');

?>