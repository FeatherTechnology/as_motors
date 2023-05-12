<?php
include '../ajaxconfig.php';

$selectec=$con->query("SELECT doc_no FROM business_com_out");
if($selectec->num_rows>0){
	$vehicleCodeAvailable=$con->query("SELECT doc_no FROM business_com_out ORDER BY business_com_out_id DESC LIMIT 1");
	while ($row=$vehicleCodeAvailable->fetch_assoc()) {
		$vehicleCode2=$row["doc_no"];
	}
	$vehicleCode1 = ltrim(strstr($vehicleCode2, 'M'), 'M')+1;
	$doc_no="DOCNUM".$vehicleCode1;
}else{
	$initialemployeecode=1;
	$doc_no="DOCNUM".$initialemployeecode;
}
echo json_encode($doc_no);
?>