<?php
include '../ajaxconfig.php';

if(isset($_POST["spare_id"])){
	$spare_id  = $_POST["spare_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM spare_creation WHERE spare_id = '".$spare_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["spare_name"];
}

if($isdel == ''){ 
	$message="You Don't Have Rights To Delete This Spare";
}
else
{ 
	$delct=$con->query("UPDATE spare_creation SET status = 1 WHERE spare_id = '".$spare_id."' ");
	if($delct){
		$message="Spare Inactivated Successfully";
	}
}

echo json_encode($message);
?>