<?php
include '../ajaxconfig.php';

if(isset($_POST["spare_id"])){
	$spare_id  = $_POST["spare_id"];
}

$getct = "SELECT * FROM spare_creation WHERE spare_id = '".$spare_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $spare_name = $row['spare_name'];
}

echo $spare_name;
?>