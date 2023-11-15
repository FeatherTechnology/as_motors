<?php
include '../ajaxconfig.php';

if(isset($_POST["responsibility_id"])){
	$responsibility_id  = $_POST["responsibility_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM basic_creation WHERE FIND_IN_SET($responsibility_id, responsibility) ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["responsibility"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Responsibility";
}
else
{ 
	$delct=$con->query("UPDATE responsibility_creation SET status = 1 WHERE responsibility_id = '".$responsibility_id."' ");
	if($delct){
		$message="Responsibility Inactivated Successfully";
	}
}

echo json_encode($message);
?>