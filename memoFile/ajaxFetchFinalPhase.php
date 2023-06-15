<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["initial_phase"])){
	$initial_phase = $_POST["initial_phase"];
}

$staff_id = array();
$reporting = array();

// get reporting staff based on staff
$getStaff = $con->query("SELECT staff_id,staff_name,reporting FROM staff_creation WHERE status = 0 AND staff_id ='".strip_tags($initial_phase)."' ");
if(mysqli_num_rows($getStaff)>0){
$row = $getStaff->fetch_assoc();
$getname = $con->query("SELECT staff_id,staff_name FROM staff_creation WHERE staff_id = '".$row["reporting"]."' ");
if(mysqli_num_rows($getname)>0){
	$report_name = $getname->fetch_assoc();
		$staff_id[]    = $report_name["staff_id"];
		$reporting[] 	= $report_name["staff_name"];
}else{
		$staff_id[]    = $row["staff_id"];
		$reporting[] 	= $row["staff_name"];
}
}else{
	$staff_id[]    = '';
	$reporting[] 	= '';
}

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["reporting"] = $reporting;

echo json_encode($departmentDetails);
?>