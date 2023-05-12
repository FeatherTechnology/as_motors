<?php
@session_start();
include 'ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["branch_id"])){
	$company_id = $_POST["branch_id"];
}


$department_id = array();
$designation_name = array();
$designation_id = array();
$department_name = array();

// get department_id and Designation_id based on
// $getInstName=$con->query("SELECT department, designation FROM basic_creation WHERE status = 0 AND company_id = '".strip_tags($company_id)."' ");
// while($row2=$getInstName->fetch_assoc()){
//     $department[]    = $row2["department"];
//     $designation[]    = $row2["designation"];
// } 

// $getDesignationName   = $row2["designation"];

$getqry = "SELECT designation_name, designation_id FROM designation_creation WHERE company_id ='".strip_tags($company_id)."' and status = 0";
$res12 = $con->query($getqry);
while($row12 = $res12->fetch_assoc())
{
    $designation_id[] = $row12["designation_id"];        
    $designation_name[] = $row12["designation_name"];  
}

$getqry = "SELECT department_name, department_id FROM department_creation WHERE company_id ='".strip_tags($company_id)."' and status = 0";
$res12 = $con->query($getqry);
while($row12 = $res12->fetch_assoc())
{
    $department_id[] = $row12["department_id"];        
    $department_name[] = $row12["department_name"];          
}

$minimumrequirementName["department_id"] = $department_id;
$minimumrequirementName["designation_id"] = $designation_id;

$minimumrequirementName["designation_name"] = $designation_name;
$minimumrequirementName["department_name"] = $department_name;

echo json_encode($minimumrequirementName);

?>