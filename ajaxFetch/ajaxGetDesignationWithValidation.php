<?php
include '../ajaxconfig.php';

if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"]; 
}
if(isset($_POST["edit_ins"])){
	$edit_ins = $_POST["edit_ins"]; 
}
    
$designation_name = array();
$designation_id = array();
$designation = array();

$getDesignationId = $con->query("SELECT * FROM basic_creation WHERE status = 0 AND FIND_IN_SET($department_id, department) > 0 ");
while($row1=$getDesignationId->fetch_assoc()){
    $designation[]    = $row1["designation"]; 
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
    if($edit_ins == '1'){
    $getqry =  $con->query("SELECT dc.designation_name, dc.designation_id
    FROM designation_creation dc
    WHERE dc.designation_id = '".$hierarchyDep[$i]."' AND dc.status = 0 ");

    }else{
    $getqry =  $con->query("SELECT dc.designation_name, dc.designation_id
    FROM designation_creation dc
    LEFT JOIN staff_creation sc ON dc.designation_id = sc.designation
    WHERE (sc.designation IS NULL OR sc.status = 1) AND dc.designation_id = '".$hierarchyDep[$i]."' AND dc.status = 0 AND (SELECT COUNT(*) FROM staff_creation WHERE designation = '".$hierarchyDep[$i]."') <= 1 ");

    }

    while($row2 = $getqry->fetch_assoc()){
        $designation_id[]= $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];       
    }
} 

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name; 

echo json_encode($designationDetails);
?>