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
//Join same table for getting reporting person details...

$getname = $con->query("SELECT scr.staff_id, scr.staff_name FROM staff_creation sc LEFT JOIN staff_creation scr ON sc.reporting = scr.staff_id WHERE sc.status = 0 AND sc.staff_id ='$assign_employee' ");
if(mysqli_num_rows($getname)>0){
$report_name = $getname->fetch_assoc();
	$staff_id[]    = $report_name["staff_id"];
	$reporting[] 	= $report_name["staff_name"];
}

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["reporting"] = $reporting;

echo json_encode($departmentDetails);
?>