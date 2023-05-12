<?php
@session_start();
include('ajaxconfig.php');

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"]; 
}
if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"]; 
}

$address1 = array();
$address2 = array();
$state = array();
$city = array();

$qry = $con->query("SELECT * FROM branch_creation WHERE branch_id = '".$branch_id."' AND status=0 ORDER BY branch_id DESC");
while($row = $qry->fetch_assoc())
{
    $address1[] = $row["address1"]; 
    $address2[] = $row["address2"]; 
    $state[] = $row["state"]; 
    $city[] = $row["city"]; 
}

$forServiceIndent["address1"] = $address1;
$forServiceIndent["address2"] = $address2;
$forServiceIndent["state"] = $state;
$forServiceIndent["city"] = $city;

echo json_encode($forServiceIndent);
?>