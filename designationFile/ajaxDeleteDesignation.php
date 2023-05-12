<?php
include '../ajaxconfig.php';

if(isset($_POST["designation_id"])){
	$designation_id  = $_POST["designation_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM designation_creation WHERE designation_name = '".$designation_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["designation_name"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Designation";
}
else
{ 
	$delct=$con->query("UPDATE designation_creation SET status = 1 WHERE designation_id = '".$designation_id."' ");
	if($delct){
		$message="Designation Inactivated Successfully";
	}
}

echo json_encode($message);
?>