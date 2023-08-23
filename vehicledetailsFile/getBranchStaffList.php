<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}

$staff_id = array();
$staff_name = array();

$getInstName=$con->query("SELECT staff_id, staff_name FROM staff_creation WHERE company_id = '$branch_id' AND status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
} 

$staffDetails["staff_id"] = $staff_id;
$staffDetails["staff_name"] = $staff_name;
    
echo json_encode($staffDetails);
?>