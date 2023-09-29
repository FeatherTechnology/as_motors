<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}

if(isset($_POST["daily_ref_id"])){
	$daily_ref_id = $_POST["daily_ref_id"];
}
if(isset($_POST["manager_comment"])){
	$manager_comment = $_POST["manager_comment"];
}else{
    $manager_comment = NULL;
}

$managerUpdate = $con->query("UPDATE `daily_performance_ref` SET `manager_comment`='$manager_comment',`manager_updated_status`='1', `manager_id`='$staffid', `manager_updated_date` = now()  WHERE `daily_performance_ref_id` = '$daily_ref_id' ") or die("Error in Update Records".$con->error);
    
if($managerUpdate){
    $result = 1;
}else{
    $result = 0;
}
echo json_encode($result);
?>