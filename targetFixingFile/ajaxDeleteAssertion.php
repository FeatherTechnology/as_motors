<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_SESSION["curdateFromIndexPage"])){
	$curdate = $_SESSION["curdateFromIndexPage"];
}

if(isset($_POST["assertion_id"])){
	$assertion_id  = $_POST["assertion_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT count(*) as assertionCnt FROM goal_setting_ref WHERE assertion = '$assertion_id' ");
while($row=$ctqry->fetch_assoc()){
	$isdel = $row["assertionCnt"];
}

if($isdel > 0){ 
	$message="You Don't Have Rights To Delete This Assertion";
}
else
{ 
	$delct=$con->query("UPDATE assertion_creation SET status = 1, updated_date = '$curdate' WHERE assertion_id = '".$assertion_id."' ");
	if($delct){
		$message="Assertion Inactivated Successfully";
	}
}

echo json_encode($message);
?>