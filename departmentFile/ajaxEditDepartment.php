<?php
include '../ajaxconfig.php';

if(isset($_POST["department_id"])){
	$department_id  = $_POST["department_id"];
}

$getct = "SELECT * FROM department_creation WHERE department_id = '".$department_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $department_name = $row['department_name'];
}

echo $department_name;
?>