<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

$result = $con->query("SELECT vendor_name FROM vendor_name_creation WHERE vendor_name_id = '".$id."' AND status=0");
$row=$result->fetch_assoc();
    $vendor_name = $row['vendor_name'];

echo $vendor_name;
?>