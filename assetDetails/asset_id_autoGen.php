<?php
include('../ajaxconfig.php');

$id  = $_POST['id'];

if($id !=''){
    $select = $con->query("SELECT asset_autoGen_id FROM asset_register WHERE asset_id = '$id' ");
    $code = $select ->fetch_assoc();
    $asset_id = $code['asset_autoGen_id'];

}else{
$myStr = "A";
$selectIC = $con->query("SELECT asset_autoGen_id FROM asset_register ORDER BY asset_id DESC LIMIT 1 ");
if($selectIC->num_rows>0)
{
    $row = $selectIC->fetch_assoc();
        $ac2 = $row["asset_autoGen_id"];

    $appno2 = ltrim(strstr($ac2, '-'), '-'); 
    $appno2 = $appno2+1;
    $asset_id = $myStr."-". "$appno2";
}
else
{
    $initialapp = $myStr."-101";
    $asset_id = $initialapp;
}
}
echo json_encode($asset_id);
?>