<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

	$delct=$con->query("UPDATE asset_name_creation SET status = 1 WHERE asset_name_id = '".$id."' ");
	if($delct){
		$message="Asset Name Inactivated Successfully";
	}

echo json_encode($message);
?>