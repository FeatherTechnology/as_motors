<?php
include '../ajaxconfig.php';

$selectec=$con->query("SELECT vehicle_code FROM vehicle_details");
if($selectec->num_rows>0){
	$vehicleCodeAvailable=$con->query("SELECT vehicle_code FROM vehicle_details ORDER BY vehicle_details_id DESC LIMIT 1");
	while ($row=$vehicleCodeAvailable->fetch_assoc()) {
		$vehicleCode2=$row["vehicle_code"];
	}
	$vehicleCode1 = ltrim(strstr($vehicleCode2, 'C'), 'C')+1;
	$vehicle_code="VC".$vehicleCode1;
}else{
	$initialemployeecode=1;
	$vehicle_code="VC".$initialemployeecode;
}
echo json_encode($vehicle_code);
?>