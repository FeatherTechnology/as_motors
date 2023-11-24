<?php
include '../ajaxconfig.php';

if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["designation"])){
	$designation = $_POST["designation"];
}

$rrrecords = array();
$rr_id = array();
$rr_name = array();
$kpi = array();
$krakpi_ref_id = array();
$rr_idArr = array();
$frequency = array();
$frequency_applicable = array();

// get work description
$getqry = $con->query("SELECT kcr.frequency, kcr.frequency_applicable, kcr.rr FROM krakpi_creation_ref kcr 
LEFT JOIN krakpi_creation kc ON kcr.krakpi_reff_id = kc.krakpi_id 
WHERE kc.company_name = '".$company_id."' AND kc.designation = '".$designation."' AND kc.status = 0 
AND kcr.rr != 'New' AND kcr.calendar = 'No' AND kcr.frequency != 'Daily Task' ");
while($row = $getqry->fetch_assoc())
{
    $frequency[] = $row["frequency"];       
    $frequency_applicable[] = $row["frequency_applicable"];       
    $rrrecords[] = $row["rr"];       
}

foreach($rrrecords as $rrlist){
    $getqry = $con->query("SELECT * FROM rr_creation_ref WHERE rr_ref_id ='".strip_tags($rrlist)."' AND status = 0");
    while($row1 = $getqry->fetch_assoc())
    {
        $rr_idArr[] = $row1["rr_ref_id"]; 
    }
}

// remove array duplicates without affect array index
$rrId=$rr_idArr;
$duplicated=array();

foreach($rrId as $k=>$v) {
    if( ($kt=array_search($v,$rrId))!==false and $k!=$kt )
    { unset($rrId[$kt]);  $duplicated[]=$v; }
}
sort($rrId); // optional
// end here

foreach($rrId as $rrValue){
    $getqry5 = $con->query("SELECT * FROM rr_creation_ref WHERE rr_ref_id ='".strip_tags($rrValue)."' AND status = 0");
    while($row2 = $getqry5->fetch_assoc())
    {
        $rr_id[] = $row2["rr_ref_id"];
        $rr_name[] = $row2["rr"];   
    }
}

$getqry1 = $con->query("SELECT frequency, frequency_applicable, kpi, krakpi_ref_id FROM krakpi_creation_ref kcr 
LEFT JOIN krakpi_creation kc ON kcr.krakpi_reff_id = kc.krakpi_id 
WHERE kc.company_name = '".$company_id."' AND kc.designation = '".$designation."' AND kc.status = 0 
AND kcr.rr = 'New' AND kcr.calendar = 'No' AND kcr.frequency != 'Daily Task'"); 
while($row3 = $getqry1->fetch_assoc())
{
    $frequency[] = $row3["frequency"];  
    $frequency_applicable[] = $row3["frequency_applicable"];  
    $krakpi_ref_id[] = $row3["krakpi_ref_id"].'+kpi';  
    $kpi[] = $row3["kpi"];
}

$mergerId = array_merge($rr_id, $krakpi_ref_id);
$mergerName = array_merge($rr_name, $kpi);

$descriptionDetails["id"] = $mergerId;
$descriptionDetails["name"] = $mergerName;
$descriptionDetails["frequency"] = $frequency;
$descriptionDetails["frequency_applicable"] = $frequency_applicable;

echo json_encode($descriptionDetails);
?>