<?php
@session_start();
include('../ajaxconfig.php');

if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

if($sbranch_id == 'Overall'){ 
	if(isset($_POST['company_name'])) {
		$company_name = $_POST['company_name'];
	}
}else if($sbranch_id != 'Overall'){

	$getBranchName = $con->query("SELECT * FROM branch_creation WHERE branch_id = '".$sbranch_id."' AND status=0 ORDER BY branch_id DESC");
	$fetch = $getBranchName->fetch_assoc();
	$company_name  = strip_tags($fetch['branch_name']);
}

$selectIC = $con->query("SELECT designation_code FROM basic_creation WHERE designation_code != '' ");
if($selectIC->num_rows>0)
{
	$codeAvailable = $con->query("SELECT designation_code FROM basic_creation WHERE designation_code != '' ORDER BY basic_creation_id DESC LIMIT 1");
	while($row = $codeAvailable->fetch_assoc()){
		$ac2 = $row["designation_code"];
	}

	$appno2 = ltrim(strstr($ac2, '-'), '-');
	$appno1 = substr($appno2, 0, strpos($appno2, "/"))+1;
	$designation_code = "DESIG-".$appno1."/".$company_name;
}
else
{
	$initialapp = "DESIG-1"."/";
	$designation_code = $initialapp.$company_name;
}
$designation_code1=preg_replace('/\s+/', '',$designation_code);
echo json_encode($designation_code1);
?>