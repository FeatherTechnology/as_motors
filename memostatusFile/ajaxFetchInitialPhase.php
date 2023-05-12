<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["assign_employee"])){
	$assign_employee = $_POST["assign_employee"];
}

$staff__id = array();
$reporting = array();
$staff_name = array();

function getEmployeeName($con, $reporting){
    $staff_name = '';
	$getname = $con->query("SELECT staff_name FROM staff_creation WHERE staff_id = '".$reporting."' ");
	while ($row = $getname->fetch_assoc()) {
		$staff_name = $row["staff_name"];
	}
	return $staff_name;
}

// get reporting staff based on staff
$getStaff = $con->query("SELECT staff_id, reporting FROM staff_creation WHERE status = 0 AND staff_id ='".strip_tags($assign_employee)."' ");
while($row=$getStaff->fetch_assoc()){
    $staff_id[]    = $row["staff_id"];
    $reporting[]    = getEmployeeName($con, $row["reporting"]);
}

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["reporting"] = $reporting;

echo json_encode($departmentDetails);
?>