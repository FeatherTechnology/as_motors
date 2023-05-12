<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$rrrecords = array();
$rr_id = array();
$rr_name = array();
$kpi = array();
$krakpi_ref_id = array();
$tag_id = array();
$tag_classification = array();
$staff_id = array();
$staff_name = array();

// get work description
$getqry = $con->query("SELECT rr FROM krakpi_creation_ref LEFT JOIN krakpi_creation ON krakpi_creation_ref.krakpi_reff_id = krakpi_creation.krakpi_id 
WHERE krakpi_creation.company_name = '".$company_id."' AND krakpi_creation.status = 0 
AND krakpi_creation_ref.rr != 'New' ");
// $getqry = "SELECT * FROM krakpi_creation_ref WHERE rr != 'New' AND status = 0";
while($row = $getqry->fetch_assoc())
{
    $rrrecords[] = $row["rr"];       
}

// for($i=0; $i<=sizeof($rrrecords)-1; $i++){
foreach($rrrecords as $rrlist){
    $getqry = $con->query("SELECT * FROM rr_creation_ref WHERE rr_ref_id ='".strip_tags($rrlist)."' AND status = 0");
    while($row2 = $getqry->fetch_assoc())
    {
        $rr_id[] = $row2["rr_ref_id"];
        $rr_name[] = $row2["rr"];   
    }
}

$getqry1 = $con->query("SELECT kpi, krakpi_ref_id FROM krakpi_creation_ref LEFT JOIN krakpi_creation ON krakpi_creation_ref.krakpi_reff_id = krakpi_creation.krakpi_id 
WHERE krakpi_creation.company_name = '".$company_id."' AND krakpi_creation.status = 0 
AND krakpi_creation_ref.rr = 'New' "); 
while($row3 = $getqry1->fetch_assoc())
{
    $krakpi_ref_id[] = $row3["krakpi_ref_id"].'+kpi';  
    $kpi[] = $row3["kpi"];
}

// get tag classification
$tagSelect = $con->query("SELECT * FROM tag_creation WHERE company_id = '".$company_id."' AND status = 0 "); 
while($row4 = $tagSelect->fetch_assoc()){	
    $tag_id[] = $row4['tag_id']; 
    $tag_classification[] = $row4['tag_classification'];	
}

// get staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE company_id = '".$company_id."' AND status=0 ORDER BY staff_id DESC"); 
while($row5 = $getStaff->fetch_assoc()){
    $staff_id[]         = $row5['staff_id']; 
    $staff_name[]       = strip_tags($row5['staff_name']);
}

$mergerId = array_merge($rr_id, $krakpi_ref_id);
$mergerName = array_merge($rr_name, $kpi);

$descriptionDetails["id"] = $mergerId;
$descriptionDetails["name"] = $mergerName;

$descriptionDetails["tag_id"] = $tag_id;
$descriptionDetails["tag_classification"] = $tag_classification;

$descriptionDetails["staff_id"] = $staff_id;
$descriptionDetails["staff_name"] = $staff_name;

echo json_encode($descriptionDetails);
?>