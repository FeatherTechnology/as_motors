<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["branch_id"])){
	$company_id = $_POST["branch_id"];
}

$hierarchyDep = array();
$department_id = array();
$department_name = array();

// get department based on hierarchy cration
$getDepartmentId = $con->query("SELECT * FROM basic_creation WHERE company_id ='".strip_tags($company_id)."' AND status = 0 ");
while($row1=$getDepartmentId->fetch_assoc()){
    $hierarchyDep[]    = $row1["department"];
}

// remove array duplicates without affect array index
$department=$hierarchyDep;
$duplicated=array();

foreach($department as $k=>$v) {
    if( ($kt=array_search($v,$department))!==false and $k!=$kt )
    { unset($department[$kt]);  $duplicated[]=$v; }
}
sort($department); // optional
// end here

for($i=0; $i<=sizeof($department)-1; $i++){
    
    $getDepartmentName = $con->query("SELECT department_id, department_name FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' AND status = 0");
    while($row2 = $getDepartmentName->fetch_assoc()){
        $department_id[] = $row2["department_id"];        
        $department_name[] = $row2["department_name"];          
    }
} 

$departmentDetails["department_id"] = $department_id;
$departmentDetails["department_name"] = $department_name;

echo json_encode($departmentDetails);
?>