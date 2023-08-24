<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_POST['company_id'])){
    $company_id = $_POST['company_id'];
}
if(isset($_POST['date'])){
    $date = $_POST['date'];
}
if(isset($_POST['vehicle_details_id'])){
    $vehicle_details_id = $_POST['vehicle_details_id'];
    $vehicleDetailIdStr = implode(',', $vehicle_details_id);
}
if(isset($_POST['vehicle_number'])){
    $vehicle_number = $_POST['vehicle_number'];
    $vehicleNoStr = implode(',', $vehicle_number);
}
if(isset($_POST['start_km'])){
    $start_km = $_POST['start_km'];
    $startKMStr = implode(',', $start_km);
}
if(isset($_POST['end_km'])){
    $end_km = $_POST['end_km'];
    $endKMStr = implode(',', $end_km);
}
if(isset($_POST['employee_name'])){
    $employee_name = $_POST['employee_name'];
    $employee_nameStr = implode(',', $employee_name);
}
if(isset($_POST['dailyKMRefId'])){
    $dailyKMRefId = $_POST['dailyKMRefId'];
    $dailyKMRefIdStr = implode(',', $dailyKMRefId);
}
if(isset($_POST['dailyKMId'])){
    $dailyKMId = $_POST['dailyKMId'];
}

$vehicleDetailIdArr = array_map('intval', explode(',', $vehicleDetailIdStr)); 
$vehicleNoArr = array_map('strval', explode(',', $vehicleNoStr)); 
$startKMArr = array_map('intval', explode(',', $startKMStr)); 
$endKMArr = array_map('intval', explode(',', $endKMStr)); 
$employee_nameStrArr = array_map('intval', explode(',', $employee_nameStr)); 
$dailyKMRefIdStrArr = array_map('intval', explode(',', $dailyKMRefIdStr)); 

// update
$updateQry = 'UPDATE daily_km SET company_id = "'.strip_tags($company_id).'", date = "'.strip_tags($date).'" 
WHERE daily_km_id = "'.mysqli_real_escape_string($mysqli, $dailyKMId).'" ';
$res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

//update
for($i=0; $i<=sizeof($vehicleDetailIdArr)-1; $i++){

    $dailyKMIdRefRun = $con->query("UPDATE `daily_km_ref` SET `vehicle_details_id`='$vehicleDetailIdArr[$i]',`vehicle_number`='$vehicleNoArr[$i]',`start_km`='$startKMArr[$i]',`end_km`='$endKMArr[$i]',`daily_km_id`='$dailyKMId',`employee_name`='$employee_nameStrArr[$i]' WHERE `daily_km_ref_id`='$dailyKMRefIdStrArr[$i]' "); 
}

if($res && $dailyKMIdRefRun){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);
?>