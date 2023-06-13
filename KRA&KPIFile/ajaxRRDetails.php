<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["designation_id"])){
	$designation_id = $_POST["designation_id"]; 
}

$kra_category = array();
$kra_creation_ref_id = array();
$rr_id = array();
$rr_ref_id = array();
$rr = array();

// get kra id name 
// $getInstName=$con->query("SELECT rr_id FROM rr_creation WHERE status = 0 AND company_name = $designation_id ");
// while ($row22 = $getInstName->fetch_assoc()) {
//     $rr_id[] = $row22["rr_id"];
// }

// for ($i = 0; $i <= sizeof($rr_id) - 1; $i++) {
    $getrrName = $con->query("SELECT rr_ref_id,rr FROM rr_creation_ref WHERE designation ='" . strip_tags($designation_id) . "' ORDER BY rr_ref_id DESC ");
    while ($row1 = $getrrName->fetch_assoc()) {
        $rr_ref_id[] = $row1["rr_ref_id"];
        $rr[] = $row1["rr"];
    }
// }

$designationDetails["rr_ref_id"] = $rr_ref_id;
$designationDetails["rr"] = $rr; 

echo json_encode($designationDetails);
?>