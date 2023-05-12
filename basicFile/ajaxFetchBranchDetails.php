<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$branch_id = array();
$branch_name = array();

// get branch name based on company
$getDepartmentName = $con->query("SELECT * FROM branch_creation WHERE company_id ='".strip_tags($company_id)."' AND status = 0");
while($row2 = $getDepartmentName->fetch_assoc()){
    $branch_id[] = $row2["branch_id"];        
    $branch_name[] = $row2["branch_name"];          
}

$branchDetails["branch_id"] = $branch_id;
$branchDetails["branch_name"] = $branch_name;

echo json_encode($branchDetails);
?>