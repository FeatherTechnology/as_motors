<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["vehicle_details_id"])){
	$vehicle_details_id = $_POST["vehicle_details_id"];
}

$date = '';
$end_km = '';

// get vehicle details
$getVehicleDetails = $con->query("SELECT daily_km.date, daily_km_ref.end_km FROM daily_km_ref LEFT JOIN daily_km ON daily_km_ref.daily_km_id = daily_km.daily_km_id 
WHERE daily_km.status = '0' AND daily_km_ref.vehicle_details_id = '".strip_tags($vehicle_details_id)."' ");
while($row = $getVehicleDetails->fetch_assoc()){

    $date = $row["date"];        
    $end_km = $row["end_km"];          
}

$vehicleDetails["date"] = $date;
$vehicleDetails["end_km"] = $end_km;

echo json_encode($vehicleDetails);
?>