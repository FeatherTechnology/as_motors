<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$department_id = array();
$department_name = array();

// get department_id and Designation_id based on
$getInstName=$con->query("SELECT department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row2=$getInstName->fetch_assoc()){
    $department_id[]    = $row2["department"];
} 

// remove array duplicates without affect array index
$department=$department_id;
$duplicated=array();

foreach($department as $k=>$v) {

    if( ($kt=array_search($v,$department))!==false and $k!=$kt )
    { unset($department[$kt]);  $duplicated[]=$v; }
}
sort($department); // optional
// end here

for($i=0; $i<=sizeof($department)-1; $i++){
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {      
        $department_name[] = $row12["department_name"];          
    }
} 

$departmentDetails["department_id"] = $department;
$departmentDetails["department_name"] = $department_name;

echo json_encode($departmentDetails);
?>