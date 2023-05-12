<?php
include '../ajaxconfig.php';

if(isset($_POST['asset_id'])){
    $asset_id = $_POST['asset_id'];
}
$assetDetails = array();
$getct = "SELECT * FROM asset_register WHERE asset_id = '".$asset_id."' AND status=0";
$result = $con->query($getct);
// $i = 0;
while($row=$result->fetch_assoc())
{
    $assetDetails['asset_value'] = $row['asset_value'];
}

echo json_encode($assetDetails);
?>