<?php
include('../ajaxconfig.php');

if(isset($_POST['assetid'])){
    $assetid = $_POST['assetid'];
}

$assetarr = array();
$selectIC = $con->query("SELECT cc.company_id as comid,cc.company_name, bc.branch_name, anc.asset_name as assetcreatename, vnc.vendor_name, ar.* FROM `asset_register` ar LEFT JOIN branch_creation bc ON ar.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id LEFT JOIN asset_name_creation anc ON ar.asset_name = anc.asset_name_id LEFT JOIN vendor_name_creation vnc ON ar.vendor_id = vnc.vendor_name_id WHERE ar.asset_id = '$assetid' ");
if($selectIC->num_rows>0)
{
    $row = $selectIC->fetch_assoc();
        // $assetarr['asset_id'] = $row["asset_id"];
        $assetarr['company_id'] = $row["comid"];
        // $assetarr['company_name'] = $row["company_name"];
        $assetarr['branch_name'] = $row["company_id"]; //branch id.
        $assetarr['asset_classification'] = $row["asset_classification"];
        $assetarr['asset_name'] = $row["asset_name"];
        // $assetarr['vendor_name'] = $row["vendor_name"];
        // $assetarr['dop'] = $row["dop"];
        // $assetarr['asset_nature'] = $row["asset_nature"];
        // $assetarr['depreciation_rate'] = $row["depreciation_rate"];
        $assetarr['asset_value'] = $row["asset_value"];
        // $assetarr['maintenance'] = $row["maintenance"];
}

echo json_encode($assetarr);
?>
