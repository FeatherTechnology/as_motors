<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id_upd"])){
	$company_id_upd = $_POST["company_id_upd"]; 
}

$kra_id = array();
$kra_creation_ref_id = array();
$kra_category = array();

// get kra id name 
$getInstName1=$con->query("SELECT kra_id FROM kra_creation WHERE status = 0 AND company_id = $company_id_upd ");
while ($row12 = $getInstName1->fetch_assoc()) {
    $kra_id[] = $row12["kra_id"];
}
for ($i = 0; $i <= sizeof($kra_id) - 1; $i++) {
    $getKraName = $con->query("SELECT * FROM kra_creation_ref WHERE kra_id ='" . strip_tags($kra_id[$i]) . "' ORDER BY kra_creation_ref_id DESC");
    while ($row2 = $getKraName->fetch_assoc()) {
        $kra_creation_ref_id[] = $row2["kra_creation_ref_id"];
        $kra_category[] = $row2["kra_category"];
    }
}

$designationDetails["kra_creation_ref_id"] = $kra_creation_ref_id ;
$designationDetails["kra_category"] = $kra_category; 

echo json_encode($designationDetails);
?>