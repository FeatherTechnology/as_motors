<?php
@session_start();
include 'ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
    $company_id = $_POST["company_id"];
}
if(isset($_POST["designation"])){
	$designation = $_POST["designation"];
}

$rr_id = array();
$rr_ref_id = array();
$rr = array();

$kra_id = array();
$kra_creation_ref_id = array();
$kra_category = array();

// get rr name
$getInstName=$con->query("SELECT rr_id FROM rr_creation WHERE status = 0 AND company_name = $company_id ");
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

// get kra details
$getInstName1=$con->query("SELECT kra_id FROM kra_creation WHERE status = 0 AND company_id = $company_id ");
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

$staff_id = array();
$staff_name = array();

// get staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE company_id = '".$company_id."' AND department = '".$designation."' AND status=0 ORDER BY staff_id DESC"); 
while($row5 = $getStaff->fetch_assoc()){
    $staff_id[]         = $row5['staff_id']; 
    $staff_name[]       = strip_tags($row5['staff_name']);
}

$kraDetailFetching["staff_id"] = $staff_id;
$kraDetailFetching["staff_name"] = $staff_name;

$kraDetailFetching["rr_ref_id"] = $rr_ref_id;
$kraDetailFetching["rr"] = $rr;

$kraDetailFetching["kra_creation_ref_id"] = $kra_creation_ref_id;
$kraDetailFetching["kra_category"] = $kra_category;

echo json_encode($kraDetailFetching);
?>