<?php
include '../ajaxconfig.php';

if(isset($_POST["project_id"])){
	$project_id  = $_POST["project_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM krakpi_creation_ref WHERE project_id = '".$project_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["project_id"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Project";
}
else
{ 
	$delct=$con->query("UPDATE project_creation SET status = 1 WHERE project_id = '".$project_id."' ");
	if($delct){
		$message="Project Inactivated Successfully";
	}
}

echo json_encode($message);
?>