<?php
include '../ajaxconfig.php';

if(isset($_POST['rgp_id'])){
    $rgp_id = $_POST['rgp_id'];
}
if(isset($_POST['asset_id'])){
    $asset_id = $_POST['asset_id'];
}

$getct = "UPDATE rgp_creation set rgp_status = 'inward' , status=1 WHERE rgp_id = '".$rgp_id."' ";
$result = $con->query($getct);

$getcc = "UPDATE asset_register set rgp_status = 'inward' WHERE asset_id = '".$asset_id."' AND status=0";
$result1 = $con->query($getcc);

if($result and $result1){
    $message = "RGP Inwarded";
}
else{
    $message = "Error";
}

echo json_encode($message);
?>