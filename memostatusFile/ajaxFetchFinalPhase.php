<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["initial_phase"])){
	$initial_phase = $_POST["initial_phase"];
}

function getEmployeeName($con, $reporting){
    $staff_name = '';
	$getname = $con->query("SELECT * FROM staff_creation WHERE staff_id = '".$reporting."' ");
	while ($row = $getname->fetch_assoc()) {
		$staff_name = $row["staff_name"];
	}
	return $staff_name;
}

$staff__id = array();
$reporting = array();

// get reporting staff based on staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE status = 0 AND reporting ='".strip_tags($initial_phase)."' ");
while($row=$getStaff->fetch_assoc()){
    $staff_id[]    = $row["staff_id"];
    $reporting[]   = getEmployeeName($con, $row["reporting"]);
} 

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["reporting"] = $reporting;

echo json_encode($departmentDetails);
?>