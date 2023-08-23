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

$vehicleDetailIdArr = array_map('intval', explode(',', $vehicleDetailIdStr)); 
$vehicleNoArr = array_map('strval', explode(',', $vehicleNoStr)); 
$startKMArr = array_map('intval', explode(',', $startKMStr)); 
$endKMArr = array_map('intval', explode(',', $endKMStr)); 
$employee_nameStrArr = array_map('intval', explode(',', $employee_nameStr)); 

$insertDailyKm = "INSERT INTO daily_km(company_id, date) VALUES ('".strip_tags($company_id)."', '".strip_tags($date)."')"; 
$dailyKMIdRun = $con->query($insertDailyKm);
$dailyKMId = $con->insert_id;

for($i=0; $i<=sizeof($vehicleDetailIdArr)-1; $i++){
    $dailyKMIdRef = "INSERT INTO daily_km_ref(vehicle_details_id, vehicle_number, start_km, end_km, daily_km_id, employee_name)
    VALUES ('".strip_tags($vehicleDetailIdArr[$i])."', '".strip_tags($vehicleNoArr[$i])."', '".strip_tags($startKMArr[$i])."', '".strip_tags($endKMArr[$i])."', 
    '".strip_tags($dailyKMId)."', '".strip_tags($employee_nameStrArr[$i])."')"; 
    $dailyKMIdRefRun = $con->query($dailyKMIdRef);
}

if($insertChecklist){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);

?>