<?php
@session_start();
include 'ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$department_id = array();
$designation_name = array();
$designation_id = array();
$department_name = array();

// get department_id and Designation_id based on
$getInstName=$con->query("SELECT * FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row=$getInstName->fetch_assoc()){
    $department_id_Arr[]    = $row["department"];
    $designationFetch[]    = $row["designation"];
    // $sub_ordinate[]    = $row["sub_ordinate"];
} 

foreach($department_id_Arr as $dept){
    
    $getqry3 = "SELECT * FROM department_creation WHERE department_id = '".$dept."' and status = 0"; 
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc())
    {
        $department_id[] = $row3["department_id"];        
        $department_name[] = $row3["department_name"];          
    }
}

// $designationMerge = array_merge($top_hierarchy, $sub_ordinate);
$designationStr = implode(",", $designationFetch);
$designationArr = array_map('intval', explode(',', $designationStr)); 

// remove array duplicates without affect array index
$designation=$designationArr;
$duplicated=array();

foreach($designation as $k=>$v) {

    if( ($kt=array_search($v,$designation))!==false and $k!=$kt )
    { unset($designation[$kt]);  $duplicated[]=$v; }

}
sort($designation);

foreach($designation as $desig){

    $getqry2 = "SELECT * FROM designation_creation WHERE designation_id = '".$desig."' and status = 0"; 
    $res2 = $con->query($getqry2);
    while($row2 = $res2->fetch_assoc())
    {
        $designation_id[] = $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];  
    }
} 

$minimumrequirementName["designation_id"] = $designation_id; 
$minimumrequirementName["designation_name"] = $designation_name;

$minimumrequirementName["department_id"] = $department_id;
$minimumrequirementName["department_name"] = $department_name;

echo json_encode($minimumrequirementName);
?>