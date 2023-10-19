<?php 
include('../ajaxconfig.php');

$assetnamearr = array();
$result=$con->query("SELECT asset_name_id, asset_name  FROM asset_name_creation where status=0 ");
while( $row = $result->fetch_assoc()){
    $asset_name_id = $row['asset_name_id'];
    $asset_name = $row['asset_name'];
    $assetnamearr[] = array("asset_name_id" => $asset_name_id, "asset_name" => $asset_name);
}

echo json_encode($assetnamearr);
?>