<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $company_id = $_SESSION["branch_id"];
}

$departmentArr = array();
$department_id = array();
$department_name = array();

// get department_id and Designation_id based on
$getInstName=$con->query("SELECT department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row2=$getInstName->fetch_assoc()){
    $departmentArr[]    = $row2["department"];
} 

// remove array duplicates without affect array index
$departmentUnique=$departmentArr;
$duplicated=array();

foreach($departmentUnique as $k=>$v) {
    if( ($kt=array_search($v,$departmentUnique))!==false and $k!=$kt )
    { unset($departmentUnique[$kt]);  $duplicated[]=$v; }

}

sort($departmentUnique); // optional

for($i=0; $i<=sizeof($departmentUnique)-1; $i++){
    $getqry = "SELECT department_name, department_id FROM department_creation WHERE department_id ='".strip_tags($departmentUnique[$i])."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
        $department_id[] = $row12["department_id"];        
        $department_name[] = $row12["department_name"];          
    }
} 

$departmentDetails["department_id"] = array_unique($department_id);
$departmentDetails["department_name"] = array_unique($department_name);
    
echo json_encode($departmentDetails);
?>