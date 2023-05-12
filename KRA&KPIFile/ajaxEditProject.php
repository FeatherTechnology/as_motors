<?php
include '../ajaxconfig.php';

if(isset($_POST["project_id"])){
	$project_id  = $_POST["project_id"];
}

$getct = "SELECT * FROM project_creation WHERE project_id = '".$project_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $project_name = $row['project_name'];
}

echo $project_name;
?>