<?php
include '../ajaxconfig.php';

$selectec=$con->query("SELECT doc_no FROM approval_requisition");
if($selectec->num_rows>0){
	$vehicleCodeAvailable=$con->query("SELECT doc_no FROM approval_requisition ORDER BY approval_requisition_id DESC LIMIT 1");
	while ($row=$vehicleCodeAvailable->fetch_assoc()) {
		$vehicleCode2=$row["doc_no"];
	}
	$vehicleCode1 = ltrim(strstr($vehicleCode2, 'M'), 'M')+1;
	$doc_no="ARDOCNUM".$vehicleCode1;
}else{
	$initialemployeecode=1;
	$doc_no="ARDOCNUM".$initialemployeecode;
}
echo json_encode($doc_no);
?>