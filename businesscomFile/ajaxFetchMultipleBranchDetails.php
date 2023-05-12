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

// convert string to array
$companyId = array_map('intval', explode(',', $company_id));
// get branch name based on company
foreach($companyId as $key => $val){ 
    $getBranchName = $con->query("SELECT * FROM branch_creation WHERE company_id ='".strip_tags($val)."' AND status = 0");
    while($row = $getBranchName->fetch_assoc()){
        $branch_id[] = $row["branch_id"];        
        $branch_name[] = $row["branch_name"];          
    }
}

$branchDetails["branch_id"] = $branch_id;
$branchDetails["branch_name"] = $branch_name;

echo json_encode($branchDetails);
?>