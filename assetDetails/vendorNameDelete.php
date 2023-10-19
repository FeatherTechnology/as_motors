<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

	$delct=$con->query("UPDATE vendor_name_creation SET status = 1 WHERE vendor_name_id = '".$id."' ");
	if($delct){
		$message="vendor Name Inactivated Successfully";
	}

echo json_encode($message);
?>