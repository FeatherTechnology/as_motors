<?php
@session_start();
include('ajaxconfig.php');
require 'excelvendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;


$companyQry = "SELECT * FROM company_creation where status = 0";
$companyresult = mysqli_query($con, $companyQry);

$branchQry = "SELECT * FROM branch_creation where status = 0";
$branchresult = mysqli_query($con, $branchQry);

$assetClassQry = "SELECT * FROM asset_register where status = 0";
$assetClassresult = mysqli_query($con, $assetClassQry);

$assetValueQry = "SELECT * FROM asset_register where status = 0";
$assetValueresult = mysqli_query($con, $assetValueQry);

$assetnameQry = "SELECT * FROM asset_name_creation where status = 0";
$asssetnameresult = mysqli_query($con, $assetnameQry);

$spareQry = "SELECT * FROM spare_creation where status = 0";
$spareresult = mysqli_query($con, $spareQry);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$sheet->setCellValue('A1', 'Asset ID');
$sheet->setCellValue('B1', 'Asset Classification');
$sheet->setCellValue('C1', 'Company Name');
$sheet->setCellValue('D1', 'Branch Name');
$sheet->setCellValue('E1', 'Asset Name');
$sheet->setCellValue('F1', 'Asset Value');
$sheet->setCellValue('G1', 'Date of put to use');
$sheet->setCellValue('H1', 'Depreciation Date');
$sheet->setCellValue('I1', 'Asset Location');
$sheet->setCellValue('J1', 'Asset Count');
$sheet->setCellValue('K1', 'Model no');
$sheet->setCellValue('L1', 'Warranty Upto');
$sheet->setCellValue('M1', 'Spares Name');


//Asset ID
$assetIDData = [];
while ($assetidrow = $assetClassresult->fetch_assoc()) {
    $assetIDData[] = $assetidrow["asset_autoGen_id"];
}

for($a=2; $a<1000; $a++){
    $assetDropdown = $sheet->getCell('A'.$a)->getDataValidation();
    $assetDropdown->setType(DataValidation::TYPE_LIST);
    $assetDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $assetDropdown->setAllowBlank(false);
    $assetDropdown->setShowInputMessage(true);
    $assetDropdown->setShowErrorMessage(true);
    $assetDropdown->setShowDropDown(true);
    $assetDropdown->setFormula1('"'.implode(',', $assetIDData).'"');
}
// Data
//Asset classification
$asset_class =  [
    'Plant & Machinary',
    'Land & Building',
    'Computer',
    'Printer and Scanner',
    'Furniture and Fixtures',
    'Electrical & fitting',
];

for($b=2; $b<1000; $b++){
$assetClassDropdown = $sheet->getCell('B'.$b)->getDataValidation();
$assetClassDropdown->setType(DataValidation::TYPE_LIST);
$assetClassDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$assetClassDropdown->setAllowBlank(false);
$assetClassDropdown->setShowInputMessage(true);
$assetClassDropdown->setShowErrorMessage(true);
$assetClassDropdown->setShowDropDown(true);
$assetClassDropdown->setFormula1('"'.implode(',', $asset_class).'"');
}

$data = [];
while ($row = $companyresult->fetch_assoc()) {
    $data[] = $row["company_name"];
}

for($c=2; $c<1000; $c++){
$companyNameDropdown = $sheet->getCell('C'.$c)->getDataValidation();
$companyNameDropdown->setType(DataValidation::TYPE_LIST);
$companyNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$companyNameDropdown->setAllowBlank(false);
$companyNameDropdown->setShowInputMessage(true);
$companyNameDropdown->setShowErrorMessage(true);
$companyNameDropdown->setShowDropDown(true);
$companyNameDropdown->setFormula1('"'.implode(',', $data).'"');
}

$branchData = [];
while ($row = $branchresult->fetch_assoc()) {
    $branchData[] = $row["branch_name"];
}

for($d=2; $d<1000; $d++){
$branchNameDropdown = $sheet->getCell('D'.$d)->getDataValidation();
$branchNameDropdown->setType(DataValidation::TYPE_LIST);
$branchNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
$branchNameDropdown->setAllowBlank(false);
$branchNameDropdown->setShowInputMessage(true);
$branchNameDropdown->setShowErrorMessage(true);
$branchNameDropdown->setShowDropDown(true);
$branchNameDropdown->setFormula1('"'.implode(',', $branchData).'"');
}

$assetData = [];
while ($assetrow = $asssetnameresult->fetch_assoc()) {
    $assetData[] = $assetrow["asset_name"];
}

for($e=2; $e<1000; $e++){
    $assetDropdown = $sheet->getCell('E'.$e)->getDataValidation();
    $assetDropdown->setType(DataValidation::TYPE_LIST);
    $assetDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $assetDropdown->setAllowBlank(false);
    $assetDropdown->setShowInputMessage(true);
    $assetDropdown->setShowErrorMessage(true);
    $assetDropdown->setShowDropDown(true);
    $assetDropdown->setFormula1('"'.implode(',', $assetData).'"');
}

//Asset Value
$assetvalueData = [];
while ($assetvaluerow = $assetValueresult->fetch_assoc()) {
    $assetvalueData[] = $assetvaluerow["asset_value"];
}

for($f=2; $f<1000; $f++){
    $assetDropdown = $sheet->getCell('F'.$f)->getDataValidation();
    $assetDropdown->setType(DataValidation::TYPE_LIST);
    $assetDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $assetDropdown->setAllowBlank(false);
    $assetDropdown->setShowInputMessage(true);
    $assetDropdown->setShowErrorMessage(true);
    $assetDropdown->setShowDropDown(true);
    $assetDropdown->setFormula1('"'.implode(',', $assetvalueData).'"');
}

$spareData = [];
while ($sparerow = $spareresult->fetch_assoc()) {
    $spareData[] = $sparerow["spare_name"];
}

for($m=2; $m<1000; $m++){
    $sparedropdown = $sheet->getCell('M'.$m)->getDataValidation();
    $sparedropdown->setType(DataValidation::TYPE_LIST);
    $sparedropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $sparedropdown->setAllowBlank(false);
    $sparedropdown->setShowInputMessage(true);
    $sparedropdown->setShowErrorMessage(true);
    $sparedropdown->setShowDropDown(true);
    $sparedropdown->setFormula1('"'.implode(',', $spareData).'"');
    $sheet->getStyle('G'.$m)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
    $sheet->getStyle('H'.$m)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
    $sheet->getStyle('L'.$m)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
}


$writer = new Xlsx($spreadsheet);
$writer->save('uploads/bulkimport/asset_details_format.xlsx');

?>