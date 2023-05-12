<?php
include '../ajaxconfig.php';

if(isset($_POST["department_id"])){
	$department_id  = $_POST["department_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM department_creation WHERE department_name = '".$department_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["department_name"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Department";
}
else
{ 
	$delct=$con->query("UPDATE department_creation SET status = 1 WHERE department_id = '".$department_id."' ");
	if($delct){
		$message="Department Inactivated Successfully";
	}
}

echo json_encode($message);
?>