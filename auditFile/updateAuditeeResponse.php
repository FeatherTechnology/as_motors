<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_POST['audit_assign_id'])){
    $audit_assign_id = $_POST['audit_assign_id'];
}
if(isset($_POST['audit_assign_ref_id'])){
    $audit_assign_ref_id = $_POST['audit_assign_ref_id'];
    $audit_assign_ref_idStr = implode(',', $audit_assign_ref_id);
}
if(isset($_POST['auditee_response'])){
    $auditee_response = $_POST['auditee_response'];
    $auditee_responseStr = implode(',', $auditee_response);
}
if(isset($_POST['action_plan'])){
    $action_plan = $_POST['action_plan'];
    $action_planStr = implode(',', $action_plan);
}
if(isset($_POST['target_date'])){
    $target_date = $_POST['target_date'];
    $target_dateStr = implode(',', $target_date);
}

$audit_assign_ref_idArr = array_map('strval', explode(',', $audit_assign_ref_idStr)); 
$auditee_responseArr = array_map('strval', explode(',', $auditee_responseStr)); 
$action_planArr = array_map('strval', explode(',', $action_planStr)); 
$target_dateArr = array_map('strval', explode(',', $target_dateStr)); 

// update
$updateQry = 'UPDATE audit_assign SET auditee_response_status = "1" WHERE audit_assign_id = "'.mysqli_real_escape_string($mysqli, $audit_assign_id).'" ';
$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

// insert
for($i=0; $i<=sizeof($audit_assign_ref_idArr)-1; $i++){
    $updateQryRef = 'UPDATE audit_assign_ref SET auditee_response = "'.strip_tags($auditee_responseArr[$i]).'", action_plan = "'.strip_tags($action_planArr[$i]).'", 
    target_date = "'.strip_tags($target_dateArr[$i]).'", auditee_response_status = "1" WHERE audit_assign_ref_id = "'.strip_tags($audit_assign_ref_idArr[$i]).'" ';
    $res = $mysqli->query($updateQryRef) or die ("Error in in update Query!.".$mysqli->error);
}

if($updateQry && $updateQryRef){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);
?>