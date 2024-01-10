<?php
include '../ajaxconfig.php';

if(isset($_POST["assertion_id"])){
	$assertion_id  = $_POST["assertion_id"];
}

$getct = "SELECT * FROM assertion_creation WHERE assertion_id = '".$assertion_id."' AND status = 0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $assertion = $row['assertion'];
}

echo $assertion;
?>