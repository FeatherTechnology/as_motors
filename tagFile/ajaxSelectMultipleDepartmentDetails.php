<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

function getCompanyName($con, $company_id){
    $branch_name = '';
    $getname = $con->query("SELECT branch_name FROM branch_creation WHERE branch_id = '".$company_id."' ");
    while ($row = $getname->fetch_assoc()) {
        $branch_name = $row["branch_name"];
    }
    return $branch_name;
}

// convert string to array
$companyId = array_map('intval', explode(',', $company_id));

$department_idArr = array();
$department_name = array();
// get department id
foreach($companyId as $key => $val){ 
    $getInstName=$con->query("SELECT department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($val, company_id) > 0 ");
    while($row=$getInstName->fetch_assoc()){
        $department_idArr[]    = $row["department"];
    } 
}

// remove array duplicates without affect array index
$department=$department_idArr;
$duplicated=array();

foreach($department as $k=>$v) {
    if( ($kt=array_search($v,$department))!==false and $k!=$kt )
    { unset($department[$kt]);  $duplicated[]=$v; }
}
sort($department);

for($i=0; $i<=sizeof($department)-1; $i++){
    $getqry = $con->query("SELECT department_id, company_id, department_name FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0");
    while($row1 = $getqry->fetch_assoc())
    {      
        $department_id[] = $row1["department_id"];          
        $branch_id[] = $row1["company_id"];          
        $branch_name[] = getCompanyName($con, $row1["company_id"]);          
        $department_name[] = $row1["department_name"];          
    }
} 

$departmentDetails["department_id"] = $department_id;
$departmentDetails["department_name"] = $department_name;
$departmentDetails["branch_name"] = $branch_name;
    
echo json_encode($departmentDetails);

?>