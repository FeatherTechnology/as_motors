<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"];
}
if(isset($_POST["staff_name"])){
	$staff_name = $_POST["staff_name"];
}

function getEmployeeName($con, $reporting){
    $staff_name = '';
	$getname = $con->query("SELECT * FROM staff_creation WHERE staff_id = '".$reporting."' ");
	while ($row = $getname->fetch_assoc()) {
		$staff_name = $row["staff_name"];
	}
	return $staff_name;
}

$staff_id = '';
$reporting_id = '';
$emp_code = '';
$reporting = '';

$getInstName=$con->query("SELECT * FROM staff_creation WHERE department = '".strip_tags($department_id)."' AND staff_id = '".strip_tags($staff_name)."' AND FIND_IN_SET($company_id, company_id) > 0 AND status = 0");
while($row=$getInstName->fetch_assoc()){
    $staff_id    = $row["staff_id"];
    $staff_name    = $row["staff_name"];
    $reporting_id    = $row["reporting"];
    $emp_code    = $row["emp_code"];
    $reporting    = getEmployeeName($con, $row["reporting"]);
} 

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["staff_name"] = $staff_name;
$departmentDetails["reporting_id"] = $reporting_id;
$departmentDetails["emp_code"] = $emp_code;
$departmentDetails["reporting"] = $reporting;
   
echo json_encode($departmentDetails);
?>