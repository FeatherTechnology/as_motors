<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $company_id = $_SESSION["branch_id"];
}

$hierarchyArr = array();
$hierarchyDep = array();
$department_id = array();
$department_name = array();

// get department based on hierarchy cration
$getDepartmentId = $con->query("SELECT * FROM basic_creation WHERE company_id ='".strip_tags($company_id)."' AND status = 0 ");
while($row1=$getDepartmentId->fetch_assoc()){
    $hierarchyArr[]    = $row1["department"];
}

// remove array duplicates without affect array index
$hierarchyDep=$hierarchyArr;
$duplicated=array();

foreach($hierarchyDep as $k=>$v) {

    if( ($kt=array_search($v,$hierarchyDep))!==false and $k!=$kt )
    { unset($hierarchyDep[$kt]);  $duplicated[]=$v; }
}

sort($hierarchyDep); // optional

for($i=0; $i<=sizeof($hierarchyDep)-1; $i++){
    
    $getDepartmentName = $con->query("SELECT department_id, department_name FROM department_creation WHERE department_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0");
    while($row2 = $getDepartmentName->fetch_assoc()){
        $department_id[] = $row2["department_id"];        
        $department_name[] = $row2["department_name"];          
    }
} 

$departmentDetails["department_id"] = $department_id;
$departmentDetails["department_name"] = $department_name;

echo json_encode($departmentDetails);

// old code
// $department = array();
// $department_id = array();
// $department_name = array();

// // get department_id and Designation_id based on
// $getInstName=$con->query("SELECT Distinct department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");

// while($row2=$getInstName->fetch_assoc()){
//     $department[]    = $row2["department"];
// } 

// for($i=0; $i<=sizeof($department)-1; $i++){
    
//     $getqry = "SELECT department_name, department_id FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0";
//     $res12 = $con->query($getqry);
//     while($row12 = $res12->fetch_assoc())
//     {
//         $department_id[] = $row12["department_id"];        
//         $department_name[] = $row12["department_name"];          
//     }
// } 

// $departmentDetails["department_id"] = $department_id;
// $departmentDetails["department_name"] = $department_name;

// echo json_encode($departmentDetails);
?>