<?php
include 'ajaxconfig.php';

$selectbc=$con->query("SELECT bankcode FROM bankmaster");
if($selectbc->num_rows>0){
	$bankavailable=$con->query("SELECT bankcode FROM bankmaster ORDER BY bankid DESC LIMIT 1");
	while ($row=$bankavailable->fetch_assoc()) {
		$bankcode2=$row["bankcode"];
	}
	$bankcode1 = ltrim(strstr($bankcode2, 'K'), 'K')+1;
	$bankcode="BANK".$bankcode1;
}else{
	$initialbankcode=1001;
	$bankcode="BANK".$initialbankcode;
}
echo json_encode($bankcode);
?>