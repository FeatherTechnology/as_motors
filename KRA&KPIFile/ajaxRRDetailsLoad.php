<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $company_id_upd = $_SESSION["branch_id"];
}

$kra_category = array();
$kra_creation_ref_id = array();
$rr_id = array();
$rr_ref_id = array();
$rr = array();

// get kra id name 
$getInstName=$con->query("SELECT rr_id FROM rr_creation WHERE status = 0 AND company_name = $company_id_upd ");
while ($row22 = $getInstName->fetch_assoc()) {
    $rr_id[] = $row22["rr_id"];
}

for ($i = 0; $i <= sizeof($rr_id) - 1; $i++) {
    $getrrName = $con->query("SELECT * FROM rr_creation_ref WHERE rr_reff_id ='" . strip_tags($rr_id[$i]) . "' ORDER BY rr_ref_id DESC ");
    while ($row1 = $getrrName->fetch_assoc()) {
        $rr_ref_id[] = $row1["rr_ref_id"];
        $rr[] = $row1["rr"];
    }
}
    
$designationDetails["rr_ref_id"] = $rr_ref_id ;
$designationDetails["rr"] = $rr; 

echo json_encode($designationDetails);
?>