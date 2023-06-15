<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["assign_employee"])){
	$assign_employee = $_POST["assign_employee"];
}

$staff_id = array();
$reporting = array();

// get reporting staff based on staff
$getStaff = $con->query("SELECT reporting FROM staff_creation WHERE status = 0 AND staff_id ='".strip_tags($assign_employee)."' ");
$row=$getStaff->fetch_assoc();

$getname = $con->query("SELECT staff_id,staff_name FROM staff_creation WHERE staff_id = '".$row["reporting"]."' ");
$report_name = $getname->fetch_assoc();
	$staff_id[]    = $report_name["staff_id"];
	$reporting[] 	= $report_name["staff_name"];


$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["reporting"] = $reporting;

echo json_encode($departmentDetails);
?>