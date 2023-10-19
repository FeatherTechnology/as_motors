<?php
include('../ajaxconfig.php');

$assetnamearr = array();
$selectIC = $con->query("SELECT asset_id,asset_autoGen_id FROM asset_register ");
if($selectIC->num_rows>0)
{
    while($row = $selectIC->fetch_assoc()){
        $asset_id = $row["asset_id"];
        $asset_code = $row["asset_autoGen_id"];
        $assetnamearr[] = array("asset_id" => $asset_id,"asset_autoGen_id" => $asset_code);
    }
}

echo json_encode($assetnamearr);
?>
