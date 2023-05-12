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

$deptQry = "SELECT * FROM department_creation";
$deptresult = mysqli_query($con, $deptQry);

$desigQry = "SELECT * FROM designation_creation";
$desigresult = mysqli_query($con, $desigQry);

$reportingToQry = "SELECT * FROM staff_creation";
$reportingtoresult = mysqli_query($con, $reportingToQry);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$sheet->setCellValue('A1', 'Company Name');
$sheet->setCellValue('B1', 'Branch Name');
$sheet->setCellValue('C1', 'Department');
$sheet->setCellValue('D1', 'Designation');
$sheet->setCellValue('E1', 'Emp Code');
$sheet->setCellValue('F1', 'Staff Name');
$sheet->setCellValue('G1', 'Reporting To');
$sheet->setCellValue('H1', 'Date Of Joining');
$sheet->setCellValue('I1', 'KRA & KPI');
$sheet->setCellValue('J1', 'Date Of Birth');
$sheet->setCellValue('K1', 'Key Skills');
$sheet->setCellValue('L1', 'Contact Number');
$sheet->setCellValue('M1', 'Email Id');

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

$deptData = [];
while ($row2 = $deptresult->fetch_assoc()) {
    $deptData[] = $row2["department_name"];
}

for($k=2; $k<1000; $k++){
    $deptNameDropdown = $sheet->getCell('C'.$k)->getDataValidation();
    $deptNameDropdown->setType(DataValidation::TYPE_LIST);
    $deptNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $deptNameDropdown->setAllowBlank(false);
    $deptNameDropdown->setShowInputMessage(true);
    $deptNameDropdown->setShowErrorMessage(true);
    $deptNameDropdown->setShowDropDown(true);
    $deptNameDropdown->setFormula1('"'.implode(',', $deptData).'"');
}

$desigData = [];
while ($row3 = $desigresult->fetch_assoc()) {
    $desigData[] = $row3["designation_name"];
}

for($l=2; $l<1000; $l++){
    $desigNameDropdown = $sheet->getCell('D'.$l)->getDataValidation();
    $desigNameDropdown->setType(DataValidation::TYPE_LIST);
    $desigNameDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $desigNameDropdown->setAllowBlank(false);
    $desigNameDropdown->setShowInputMessage(true);
    $desigNameDropdown->setShowErrorMessage(true);
    $desigNameDropdown->setShowDropDown(true);
    $desigNameDropdown->setFormula1('"'.implode(',', $desigData).'"');
}
$reportingToData = [];
while ($row4 = $reportingtoresult->fetch_assoc()) {
    $reportingToData[] = $row4["staff_name"];
}

for($m=2; $m<1000; $m++){
    $reportingToDropdown = $sheet->getCell('G'.$m)->getDataValidation();
    $reportingToDropdown->setType(DataValidation::TYPE_LIST);
    $reportingToDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $reportingToDropdown->setAllowBlank(false);
    $reportingToDropdown->setShowInputMessage(true);
    $reportingToDropdown->setShowErrorMessage(true);
    $reportingToDropdown->setShowDropDown(true);
    $reportingToDropdown->setFormula1('"'.implode(',', $reportingToData).'"');
}

$qry = "SELECT krakpi_id,company_name, designation FROM krakpi_creation WHERE 1 AND status=0 ORDER BY krakpi_id DESC";
$res =$con->query($qry)or die("Error in Get All Records".$con->error);
$j=0;
while($fetchInstitute = $res->fetch_assoc()){
    $designation_id[$j] =  $fetchInstitute['designation'];
    $j++;
}
for($i=0; $i<=sizeof($designation_id)-1; $i++){
    $selectDesignationName=$con->query("SELECT * FROM designation_creation WHERE designation_id = '".$designation_id[$i]."' ");
    while($row5=$selectDesignationName->fetch_assoc()){
        $krakpiData[]    = $row5["designation_name"];
    }
}

for($n=2; $n<1000; $n++){
    $krakpiDropdown = $sheet->getCell('I'.$n)->getDataValidation();
    $krakpiDropdown->setType(DataValidation::TYPE_LIST);
    $krakpiDropdown->setErrorStyle(DataValidation::STYLE_INFORMATION);
    $krakpiDropdown->setAllowBlank(false);
    $krakpiDropdown->setShowInputMessage(true);
    $krakpiDropdown->setShowErrorMessage(true);
    $krakpiDropdown->setShowDropDown(true);
    $krakpiDropdown->setFormula1('"'.implode(',', $krakpiData).'"');
}

$sheet->getStyle('H2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');
$sheet->getStyle('J2')->getNumberFormat()->setFormatCode('yyyy/mm/dd');

$writer = new Xlsx($spreadsheet);
$writer->save('uploads/downloadfiles/staffbulksample.xlsx');

?>