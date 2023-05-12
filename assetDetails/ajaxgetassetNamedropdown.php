<?php 
include('../ajaxconfig.php');
if(isset($_POST['asset_class'])){
    $asset_class = $_POST['asset_class'];
}

$assetarr = array();
$result=$con->query("SELECT * FROM asset_register where asset_classification = '".$asset_class."' and status=0");
while( $row = $result->fetch_assoc()){
    $asset_id = $row['asset_id'];
    $asset_name = $row['asset_name'];
    $assetarr[] = array("asset_id" => $asset_id, "asset_name" => $asset_name);
}
echo json_encode($assetarr);
?>