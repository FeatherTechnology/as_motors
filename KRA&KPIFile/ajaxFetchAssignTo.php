<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["designation"])){
	$designation = $_POST["designation"];
}
$staff_id = array();
$staff_name = array();

// get staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE company_id = '".$company_id."' AND department = '".$designation."' AND status=0 ORDER BY staff_id DESC"); 
while($row5 = $getStaff->fetch_assoc()){
    $staff_id[]         = $row5['staff_id']; 
    $staff_name[]       = strip_tags($row5['staff_name']);
}

$descriptionDetails["staff_id"] = $staff_id;
$descriptionDetails["staff_name"] = $staff_name;

echo json_encode($descriptionDetails);
?>