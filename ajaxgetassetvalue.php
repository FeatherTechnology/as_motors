<?php
@session_start();
include('ajaxconfig.php');

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"]; 
}
if(isset($_POST["asset_id"])){
	$asset_id1 = $_POST["asset_id"]; 
}

$asset_id = array();
$asset_value = array();

    $getassetName = $con->query("SELECT asset_id, asset_value FROM asset_register WHERE asset_id ='".$asset_id1."' "); 
    while($row2 = $getassetName->fetch_assoc()){
        $asset_id[] = $row2["asset_id"];        
        $asset_value[] = $row2["asset_value"];          
    }

$assetDetails["asset_id"] = $asset_id;
$assetDetails["asset_value"] = $asset_value;

echo json_encode($assetDetails);
?>