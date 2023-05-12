<?php
@session_start();
include 'ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
    $company_id = $_POST["company_id"];
}

$rr_id = array();
$rr_ref_id = array();
$rr = array();

$kra_id = array();
$kra_creation_ref_id = array();
$kra_category = array();

// get rr name
$getInstName= $con->query("SELECT rr_id FROM rr_creation WHERE status = 0 AND company_name = $company_id ");
while ($row = $getInstName->fetch_assoc()) {
    $rr_id[] = $row["rr_id"];
}
for ($i = 0; $i <= sizeof($rr_id) - 1; $i++) {
    $getrrName = $con->query("SELECT * FROM rr_creation_ref WHERE rr_reff_id ='" . strip_tags($rr_id[$i]) . "' ORDER BY rr_ref_id DESC ");
    while ($row1 = $getrrName->fetch_assoc()) {
        $rr_ref_id[] = $row1["rr_ref_id"];
        $rr[] = $row1["rr"];
    }
}

// get kra details
$getInstName1=$con->query("SELECT kra_id FROM kra_creation WHERE status = 0 AND company_id = $company_id ");
while ($row2 = $getInstName1->fetch_assoc()) {
    $kra_id[] = $row2["kra_id"];
}
for ($i = 0; $i <= sizeof($kra_id) - 1; $i++) {
    $getKraName = $con->query("SELECT * FROM kra_creation_ref WHERE kra_id ='" . strip_tags($kra_id[$i]) . "' ORDER BY kra_creation_ref_id DESC");
    while ($row3 = $getKraName->fetch_assoc()) {
        $kra_creation_ref_id[] = $row3["kra_creation_ref_id"];
        $kra_category[] = $row3["kra_category"];
    }
}

// get project details
$getInstName1=$con->query("SELECT * FROM project_creation WHERE status = 0");
while ($row2 = $getInstName1->fetch_assoc()) {
    $project_id[] = $row2["project_id"];
    $project_name[] = $row2["project_name"];
}


$kraDetailFetching["rr_ref_id"] = $rr_ref_id;
$kraDetailFetching["rr"] = $rr;

$kraDetailFetching["kra_creation_ref_id"] = $kra_creation_ref_id;
$kraDetailFetching["kra_category"] = $kra_category;

$kraDetailFetching["project_id"] = $project_id;
$kraDetailFetching["project_name"] = $project_name;

echo json_encode($kraDetailFetching);
?>