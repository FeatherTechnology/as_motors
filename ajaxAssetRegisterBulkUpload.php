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

$assetnameQry = "SELECT * FROM asset_name_creation where status = 0";
$asssetnameresult = mysqli_query($con, $assetnameQry);

$vendornameQry = "SELECT * FROM vendor_name_creation where status = 0";
$vendornameresult = mysqli_query($con, $vendornameQry);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$sheet->setCellValue('A1', 'Company Name');
$sheet->setCellValue('B1', 'Branch Name');
$sheet->setCellValue('C1', 'Asset Classification');
$sheet->setCellValue('D1', 'Asset Name');
$sheet->setCellValue('E1', 'Vendor Name');
$sheet->setCellValue('F1', 'Date of Purchase');
$sheet->setCellValue('G1', 'Asset Nature');
$sheet->setCellValue('H1', 'Depreciation Rate');
$sheet->setCellValue('I1', 'Asset/Book Value');
$sheet->setCellValue('J1', 'Maintenance Required');
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

$classficationData = ["Plant & Machinary","Land & Building","Computer","Printer and Scanner","Furniture and Fixtures","Electrical & fitting"];

for($c=2; $c<1000; $c++){
    $classficationDropdown = $sheet->getCell('C'.$c)->getDataValidation();
    $classficationDropdown->setType(DataValidation::TYPE_LIST);
    $classficationDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $classficationDropdown->setAllowBlank(false);
    $classficationDropdown->setShowInputMessage(true);
    $classficationDropdown->setShowErrorMessage(true);
    $classficationDropdown->setShowDropDown(true);
    $classficationDropdown->setFormula1('"'.implode(',', $classficationData).'"');
}

$assetData = [];
while ($assetrow = $asssetnameresult->fetch_assoc()) {
    $assetData[] = $assetrow["asset_name"];
}

for($a=2; $a<1000; $a++){
    $assetDropdown = $sheet->getCell('D'.$a)->getDataValidation();
    $assetDropdown->setType(DataValidation::TYPE_LIST);
    $assetDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $assetDropdown->setAllowBlank(false);
    $assetDropdown->setShowInputMessage(true);
    $assetDropdown->setShowErrorMessage(true);
    $assetDropdown->setShowDropDown(true);
    $assetDropdown->setFormula1('"'.implode(',', $assetData).'"');
}

$vendorData = [];
while ($vendorrow = $vendornameresult->fetch_assoc()) {
    $vendorData[] = $vendorrow["vendor_name"];
}

for($b=2; $b<1000; $b++){
    $vendorDropdown = $sheet->getCell('E'.$b)->getDataValidation();
    $vendorDropdown->setType(DataValidation::TYPE_LIST);
    $vendorDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $vendorDropdown->setAllowBlank(false);
    $vendorDropdown->setShowInputMessage(true);
    $vendorDropdown->setShowErrorMessage(true);
    $vendorDropdown->setShowDropDown(true);
    $vendorDropdown->setFormula1('"'.implode(',', $vendorData).'"');
}

$natureData = ["Moveable","Immoveable"];

for($d=2; $d<1000; $d++){
    $natureDropdown = $sheet->getCell('G'.$d)->getDataValidation();
    $natureDropdown->setType(DataValidation::TYPE_LIST);
    $natureDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $natureDropdown->setAllowBlank(false);
    $natureDropdown->setShowInputMessage(true);
    $natureDropdown->setShowErrorMessage(true);
    $natureDropdown->setShowDropDown(true);
    $natureDropdown->setFormula1('"'.implode(',', $natureData).'"');
}

$maintanceData = ["Yes","No"];

for($d=2; $d<1000; $d++){
    $maintanceDropdown = $sheet->getCell('J'.$d)->getDataValidation();
    $maintanceDropdown->setType(DataValidation::TYPE_LIST);
    $maintanceDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $maintanceDropdown->setAllowBlank(false);
    $maintanceDropdown->setShowInputMessage(true);
    $maintanceDropdown->setShowErrorMessage(true);
    $maintanceDropdown->setShowDropDown(true);
    $maintanceDropdown->setFormula1('"'.implode(',', $maintanceData).'"');
    $sheet->getStyle('F'.$d)->getNumberFormat()->setFormatCode('yyyy/mm/dd');
}

// $sheet->getStyle('J2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');

$writer = new Xlsx($spreadsheet);
$writer->save('uploads/downloadfiles/assetregisterbulksample.xlsx');

?>