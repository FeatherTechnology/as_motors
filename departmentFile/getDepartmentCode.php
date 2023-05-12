<?php
@session_start();
include('../ajaxconfig.php');

if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}
if(isset($_POST['department_name'])) {
    $department_name = $_POST['department_name'];
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

$str = preg_replace('/\s+/', '', $department_name); 
$myStr = substr($str, 0, 3);

$selectIC = $con->query("SELECT department_code FROM basic_creation WHERE department_code != '' ");
if($selectIC->num_rows>0)
{
	$codeAvailable = $con->query("SELECT department_code FROM basic_creation WHERE department_code != '' ORDER BY basic_creation_id DESC LIMIT 1");
	while($row = $codeAvailable->fetch_assoc()){
		$ac2 = $row["department_code"];
	}

	$appno2 = ltrim(strstr($ac2, '-'), '-');
	$appno1 = substr($appno2, 0, strpos($appno2, "/"))+1;
	$department_code = $myStr."-".$appno1."/".$company_name;
}	
else
{
	$initialapp = $myStr."-1"."/";
	$department_code = $initialapp.$company_name;
}
$department_code1=preg_replace('/\s+/', '',$department_code);

echo json_encode($department_code1);
?>