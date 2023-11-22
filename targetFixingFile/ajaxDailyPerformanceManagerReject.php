<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}
if(isset($_SESSION["curdateFromIndexPage"])){
    $curdate = $_SESSION["curdateFromIndexPage"];
}
if(isset($_POST["daily_ref_id"])){
	$daily_ref_id = $_POST["daily_ref_id"];
}


//manager_updated_status = 1 -- Approved. 2 -- Rejected.
$managerUpdate = $con->query("UPDATE `daily_performance_ref` SET `manager_updated_status`='2', `manager_id`='$staffid', `manager_updated_date` = '$curdate'  WHERE `daily_performance_ref_id` = '$daily_ref_id' ") or die("Error in Update Records".$con->error);


if($managerUpdate){
    $result = 1;
}else{
    $result = 0;
}
echo json_encode($result);
?>