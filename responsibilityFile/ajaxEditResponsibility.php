<?php
include '../ajaxconfig.php';

if(isset($_POST["responsibility_id"])){
	$responsibility_id  = $_POST["responsibility_id"];
}

$getct = "SELECT * FROM responsibility_creation WHERE responsibility_id = '".$responsibility_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $responsibility_name = $row['responsibility_name'];
}

echo $responsibility_name;
?>