<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["desgn_id"])){
	$desgn_id = $_POST["desgn_id"];
}

$staff_id = array();
$staff_name = array();
$emp_code = array();

$fromBasic = $con->query("SELECT `report_to` FROM `basic_creation` WHERE FIND_IN_SET(".strip_tags($desgn_id).", `designation`) && status = 0 ");
while($reportTo = $fromBasic->fetch_assoc()){
    $reportTo_person_desgnID[] = $reportTo['report_to'];
}

$reportTo_person_desgn = implode(',', $reportTo_person_desgnID);


//From the client side the requirement is changed //The staff can work in any branch but for some staff the reporting person are in main branch.so removed the company id in the query.
// $getInstName=$con->query("SELECT * FROM staff_creation WHERE designation = '".strip_tags($reportTo_person_desgnID)."' AND FIND_IN_SET($company_id, company_id) > 0 AND status = 0");
// $getInstName=$con->query("SELECT * FROM staff_creation WHERE designation = '".strip_tags($reportTo_person_desgnID)."' AND status = 0");
$getInstName=$con->query("SELECT * FROM staff_creation WHERE FIND_IN_SET(designation, '$reportTo_person_desgn') AND status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
    $emp_code[]    = $row2["emp_code"];
} 

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["staff_name"] = $staff_name;
$departmentDetails["emp_code"] = $emp_code;
    
echo json_encode($departmentDetails);
?>