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
if(isset($_POST["actualachieve"])){
	$actual_achieve = $_POST["actualachieve"];
}
if(isset($_POST["sdate"])){
	$sdate = $_POST["sdate"];
}
if(isset($_POST["wstatus"])){
	$wstatus = $_POST["wstatus"];
}
if(isset($_POST["manager_comment"])){
	$manager_comment = $_POST["manager_comment"];
}else{
    $manager_comment = NULL;
}
if(isset($_POST["goal_setting_ref_id"])){
	$goal_setting_ref_id = $_POST["goal_setting_ref_id"];
}
if(isset($_POST["assertion_table_sno"])){
	$assertion_table_sno = $_POST["assertion_table_sno"];
}

$managerUpdate = $con->query("UPDATE `daily_performance_ref` SET `manager_comment`='$manager_comment',`manager_updated_status`='1', `manager_id`='$staffid', `manager_updated_date` = '$curdate'  WHERE `daily_performance_ref_id` = '$daily_ref_id' ") or die("Error in Update Records".$con->error);

$qry2="UPDATE `daily_performance_ref` SET `actual_achieve`='$actual_achieve', `status`='$wstatus' WHERE `daily_performance_ref_id` = '$daily_ref_id' ";
$update_assign_ref=$mysqli->query($qry2) or die("Error ".$mysqli->error);	

$update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='$wstatus' WHERE `goal_setting_ref_id`='$goal_setting_ref_id' ") or die("Error ".$mysqli->error);

if($wstatus == '1'){
    $update_goal_ref = $mysqli->query("UPDATE `goal_setting_ref` SET `status`='1'  WHERE  `assertion_table_sno`='$assertion_table_sno' && DATE_FORMAT(goal_month, '%Y-%m-%d') < '$sdate'") or die("Error ".$mysqli->error); //After Statisfied all Task the  status will changes as satisfied.
}

if($managerUpdate){
    $result = 1;
}else{
    $result = 0;
}
echo json_encode($result);
?>