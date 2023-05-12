<?php 
include('../ajaxconfig.php');
if(isset($_POST['asset_name'])){
    $asset_name = $_POST['asset_name'];
}

$result=$con->query("SELECT * FROM asset_register where asset_id = '".$asset_name."' and status=0");
$row = $result->fetch_assoc();
$asset_value = $row['asset_value'];

echo json_encode($asset_value);
?>