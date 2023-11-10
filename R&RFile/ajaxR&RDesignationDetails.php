<?php
//Also using in kra_kpi_report.js
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"]; 
}
    
$hierarchyDesig = array();
$designation_name = array();
$designation_id = array();
$designation = array();

// get designation based on hierarchy
$getDesignationId=$con->query("SELECT * FROM basic_creation WHERE status = 0 AND FIND_IN_SET($department_id, department) > 0 ");
while($row=$getDesignationId->fetch_assoc()){
    $designationArr[]    = $row["designation"]; 
    // $sub_ordinate[]    = $row1["sub_ordinate"]; 
}

// $hierarchyDesig = array_merge($top_hierarchy, $sub_ordinate);

$designationStr = implode(",", $designationArr);
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

    $getDesignationName = $con->query("SELECT designation_id, designation_name FROM designation_creation WHERE designation_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0"); 
    while($row2 = $getDesignationName->fetch_assoc()){
        $designation_id[]= $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];       
    }
} 

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name;

echo json_encode($designationDetails);
?>