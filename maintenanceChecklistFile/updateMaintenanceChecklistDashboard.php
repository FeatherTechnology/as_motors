<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_POST['maintenanceChceklistId'])){
    $maintenanceChceklistId = $_POST['maintenanceChceklistId'];
} 
if(isset($_POST['maintenanceChceklistRefId'])){
    $maintenanceChceklistRefId = $_POST['maintenanceChceklistRefId'];
    $maintenanceChceklistRefIdStr = implode(',', $maintenanceChceklistRefId);
}
if(isset($_POST['checkedid'])){
    $checkedid = $_POST['checkedid'];
    $checkedidStr = implode(',', $checkedid);
}
if(isset($_POST['reason'])){
    $reason = $_POST['reason'];
    $reasonStr = implode(',', $reason);
}

$checkedidArr = array_map('intval', explode(',', $checkedidStr)); 
$maintenanceChceklistRefIdArr = array_map('strval', explode(',', $maintenanceChceklistRefIdStr));
$reasonArr = array_map('strval', explode(',', $reasonStr)); 

// insert
$updateQry = 'UPDATE maintenance_checklist SET responder_status = 1 WHERE maintenance_checklist_id = "'.strip_tags($maintenanceChceklistId).'" AND status = 0 ';
$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

// insert ref
for($i=0; $i<=sizeof($checkedidArr)-1; $i++){
    $updateQryRef = 'UPDATE maintenance_checklist_ref SET responder_reason = "'.strip_tags($reasonArr[$i]).'", responder_status_ref = 1 WHERE maintenance_checklist_id = "'.strip_tags($maintenanceChceklistId).'"
    AND maintenance_checklist_ref_id = "'.strip_tags($maintenanceChceklistRefIdArr[$i]).'" ';
    $res = $mysqli->query($updateQryRef) or die ("Error in in update Query!.".$mysqli->error); 
}

if($updateQry && $updateQryRef){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);
?>