<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

	$delct=$con->query("UPDATE policy_company_creation SET status = 1 WHERE policy_company_id = '".$id."' ");
	if($delct){
		$message="Insurance Inactivated Successfully";
	}


echo json_encode($message);
?>