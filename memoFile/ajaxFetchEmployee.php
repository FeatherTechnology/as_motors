<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["to_department"])){
	$to_department = $_POST["to_department"];
}

$staff_id = array();
$staff_name = array();

// get staff based on department
$getStaff = $con->query("SELECT * FROM staff_creation WHERE status = 0 AND department ='".strip_tags($to_department)."' ");
while($row=$getStaff->fetch_assoc()){
    $staff_id[]    = $row["staff_id"];
    $staff_name[]    = $row["staff_name"];
}

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["staff_name"] = $staff_name;

echo json_encode($departmentDetails);
?>