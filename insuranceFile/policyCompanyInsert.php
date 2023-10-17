<?php
include '../ajaxconfig.php';

if (isset($_POST['policy_com_id'])) {
    $policy_com_id = $_POST['policy_com_id'];
}
if (isset($_POST['policy_com'])) {
    $policy_com = $_POST['policy_com'];
}


$depNme='';
$depStatus='';
$selectinsurance = $con->query("SELECT * FROM policy_company_creation WHERE policy_company = '".$policy_com."' ");
if(mysqli_num_rows($selectinsurance) > 0){
	while ($row=$selectinsurance->fetch_assoc()){
		$depNme    = $row["policy_company"];
		$depStatus  = $row["status"];
	}
}

if($depNme != '' && $depStatus == 0){
	$message="Policy Company Already Exists, Please Enter a Different Name!";
}
else if($depNme != '' && $depStatus == 1){
	$updateinsurance=$con->query("UPDATE policy_company_creation SET status=0 WHERE policy_company='".$policy_com."' ");
	$message="Policy Company Added Succesfully";
}
else{
	if($policy_com_id>0){
		$updateinsurance=$con->query("UPDATE policy_company_creation SET policy_company='".$policy_com."' WHERE policy_company_id='".$policy_com_id."' ");
		if($updateinsurance == true){
		    $message="Policy Company Updated Succesfully";
	    }
    }
	else{
	    $insertinsurance=$con->query("INSERT INTO policy_company_creation(policy_company,created_date) VALUES('".strip_tags($policy_com)."', current_timestamp() )");
	    if($insertinsurance == true){
		    $message="Policy Company Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>