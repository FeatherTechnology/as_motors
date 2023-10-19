<?php
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id  = $_POST["id"];
}

$result = $con->query("SELECT asset_name FROM asset_name_creation WHERE asset_name_id = '".$id."' AND status=0");
$row=$result->fetch_assoc();
    $asset_name = $row['asset_name'];

echo $asset_name;
?>