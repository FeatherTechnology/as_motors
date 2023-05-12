<?php
include '../ajaxconfig.php';

if(isset($_POST["designation_id"])){
	$designation_id  = $_POST["designation_id"];
}

$getct = "SELECT * FROM designation_creation WHERE designation_id = '".$designation_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $designation_name = $row['designation_name'];
}

echo $designation_name;
?>