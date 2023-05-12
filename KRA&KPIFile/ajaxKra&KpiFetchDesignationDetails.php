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
    
$designation_name = array();
$designation_id = array();
$designation = array();

// fetch company id
$qry = "SELECT * FROM branch_creation WHERE company_id = '".$company_id."' AND status=0"; 
$res = $con->query($qry);
while($row = $res->fetch_assoc())
{
    $branch_id = $row['branch_id'];
}

// get designation based on hierarchy
$getDesignationId = $con->query("SELECT * FROM basic_creation WHERE status = 0 AND company_id ='".strip_tags($branch_id)."' AND FIND_IN_SET($department_id, department) > 0 ");
while($row1=$getDesignationId->fetch_assoc()){
    $designation[]    = $row1["designation"]; 
    // $sub_ordinate[]    = $row1["sub_ordinate"]; 
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
    while($row2 = $getqry->fetch_assoc()){
        $designation_id[]= $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];       
    }
} 

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name; 

echo json_encode($designationDetails);
?>