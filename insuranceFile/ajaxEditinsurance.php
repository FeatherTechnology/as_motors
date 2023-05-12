<?php
include '../ajaxconfig.php';

if(isset($_POST["insurance_id"])){
	$insurance_id  = $_POST["insurance_id"];
}

$getct = "SELECT * FROM insurance_creation WHERE insurance_id = '".$insurance_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $insurance_name = $row['insurance_name'];
}

echo $insurance_name;
?>