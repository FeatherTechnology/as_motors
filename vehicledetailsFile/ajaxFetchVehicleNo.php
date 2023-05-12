<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$vehicle_details_id = array();
$vehicle_number = array();

// get vehicle details
$getVehicleNo = $con->query("SELECT * FROM vehicle_details WHERE company_id ='".strip_tags($company_id)."' AND status = 0");
while($row = $getVehicleNo->fetch_assoc()){
    $vehicle_details_id[] = $row["vehicle_details_id"];        
    $vehicle_number[] = $row["vehicle_number"];          
}

$vehicleDetails["vehicle_details_id"] = $vehicle_details_id;
$vehicleDetails["vehicle_number"] = $vehicle_number;

echo json_encode($vehicleDetails);
?>