<?php
include '../ajaxconfig.php';

if(isset($_POST["insurance_id"])){
	$insurance_id  = $_POST["insurance_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM insurance_creation WHERE insurance_id = '".$insurance_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["insurance_name"];
}

if($isdel == ''){ 
	$message="You Don't Have Rights To Delete This Insurance";
}
else
{ 
	$delct=$con->query("UPDATE insurance_creation SET status = 1 WHERE insurance_id = '".$insurance_id."' ");
	if($delct){
		$message="Insurance Inactivated Successfully";
	}
}

echo json_encode($message);
?>