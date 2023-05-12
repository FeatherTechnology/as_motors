<?php
include '../ajaxconfig.php';

if(isset($_POST['asset_class'])){
    $asset_class = $_POST['asset_class'];
}
$assetDetails = array();
$getct = "SELECT * FROM asset_register WHERE asset_classification = '".$asset_class."' AND status=0";
$result = $con->query($getct);
$i = 0;
while($row=$result->fetch_assoc())
{
    $assetDetails[$i]['asset_name'] = $row['asset_name'];
    $assetDetails[$i]['asset_id'] = $row['asset_id'];
    $i++;
}

echo json_encode($assetDetails);
?>