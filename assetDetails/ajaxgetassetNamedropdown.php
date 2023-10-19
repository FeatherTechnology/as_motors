<?php 
include('../ajaxconfig.php');
if(isset($_POST['asset_class'])){
    $asset_class = $_POST['asset_class'];
}

$assetarr = array();
$result=$con->query("SELECT ar.asset_id, anc.asset_name_id, anc.asset_name FROM asset_register ar LEFT JOIN asset_name_creation anc ON ar.asset_name = anc.asset_name_id  where ar.asset_classification = '".$asset_class."' and ar.status=0");
while( $row = $result->fetch_assoc()){
    $asset_id = $row['asset_id'];
    $asset_name_id = $row['asset_name_id'];
    $asset_name = $row['asset_name'];
    $assetarr[] = array("asset_id" => $asset_id, "asset_name_id" => $asset_name_id, "asset_name" => $asset_name);
}
echo json_encode($assetarr);
?>