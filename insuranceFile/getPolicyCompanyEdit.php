<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

$result = $con->query("SELECT * FROM policy_company_creation WHERE policy_company_id = '".$id."' AND status=0");
$row=$result->fetch_assoc();
    $policy_company = $row['policy_company'];


echo $policy_company;
?>