<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"];
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
$rr_idArr = array();

// get work description
$getqry = $con->query("SELECT rr FROM krakpi_creation_ref LEFT JOIN krakpi_creation ON krakpi_creation_ref.krakpi_reff_id = krakpi_creation.krakpi_id 
WHERE krakpi_creation.company_name = '".$company_id."' AND krakpi_creation.department = '".$department_id."' AND krakpi_creation.status = 0 
AND krakpi_creation_ref.rr != 'New' AND krakpi_creation_ref.calendar = 'No' ");
while($row = $getqry->fetch_assoc())
{
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

$getqry1 = $con->query("SELECT kpi, krakpi_ref_id FROM krakpi_creation_ref LEFT JOIN krakpi_creation ON krakpi_creation_ref.krakpi_reff_id = krakpi_creation.krakpi_id 
WHERE krakpi_creation.company_name = '".$company_id."' AND krakpi_creation.department = '".$department_id."' AND krakpi_creation.status = 0 
AND krakpi_creation_ref.rr = 'New' AND krakpi_creation_ref.calendar = 'No' "); 
while($row3 = $getqry1->fetch_assoc())
{
    $krakpi_ref_id[] = $row3["krakpi_ref_id"].'+kpi';  
    $kpi[] = $row3["kpi"];
}

// get designation based on hierarchy
$getDesignationId = $con->query("SELECT * FROM basic_creation WHERE status = 0 AND company_id ='".strip_tags($company_id)."' AND FIND_IN_SET($department_id, department) > 0 ");
while($row4=$getDesignationId->fetch_assoc()){
    $designation[]    = $row4["designation"]; 
}

$designationStr = implode(",", $designation);
$designation = array_map('intval', explode(',', $designationStr)); 

// remove array duplicates without affect array index
$hierarchyDep=$designation;
$duplicated=array();
foreach($hierarchyDep as $k=>$v) {
    if( ($kt=array_search($v,$hierarchyDep))!==false and $k!=$kt )
    { unset($hierarchyDep[$kt]);  $duplicated[]=$v; }
}
sort($hierarchyDep); // optional

for($i=0; $i<=sizeof($hierarchyDep)-1; $i++){
    $getqry =  $con->query("SELECT designation_name, designation_id FROM designation_creation WHERE designation_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0"); 
    while($row5 = $getqry->fetch_assoc()){
        $designation_id[]= $row5["designation_id"];        
        $designation_name[] = $row5["designation_name"];       
    }
} 

$mergerId = array_merge($rr_id, $krakpi_ref_id);
$mergerName = array_merge($rr_name, $kpi);

$descriptionDetails["id"] = $mergerId;
$descriptionDetails["name"] = $mergerName;

$descriptionDetails["designation_id"] = $designation_id;
$descriptionDetails["designation_name"] = $designation_name; 

echo json_encode($descriptionDetails);
?>