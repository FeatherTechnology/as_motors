<?php
include '../ajaxconfig.php';

if(isset($_POST["staff_id"])){
	$staffid = $_POST["staff_id"];
}

$getreportingperson = $con->query("SELECT reporting FROM staff_creation WHERE staff_id = '$staffid' AND status = 0");
$rpinfo = $getreportingperson->fetch_assoc();
    $departmentDetails["reporting_id"] = $rpinfo["reporting"];
    
echo json_encode($departmentDetails);
?>