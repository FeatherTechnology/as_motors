<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["branch_id"])){
	$branch_id_post = $_POST["branch_id"];
}

$branch_id = array();
$branch_name = array();
$company_id = array();

// get branch id based company name
$getCompanyId = $con->query("SELECT * FROM branch_creation WHERE branch_id ='".$branch_id_post."' AND status = 0");
while($row = $getCompanyId->fetch_assoc()){      
    $company_id[] = $row["company_id"];          
}

// get branch name based on company
for($i=0; $i<=sizeof($company_id)-1; $i++){
    $getBranchName = $con->query("SELECT * FROM branch_creation WHERE company_id ='".$company_id[$i]."' AND status = 0");
    while($row1 = $getBranchName->fetch_assoc()){
        $branch_id[] = $row1["branch_id"];        
        $branch_name[] = $row1["branch_name"];          
    }
}

$branchDetails["branch_id"] = $branch_id;
$branchDetails["branch_name"] = $branch_name;

echo json_encode($branchDetails);
?>