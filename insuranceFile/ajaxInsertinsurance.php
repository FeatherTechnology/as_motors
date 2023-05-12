<?php
include '../ajaxconfig.php';

if (isset($_POST['insurance_id'])) {
    $insurance_id = $_POST['insurance_id'];
}
if (isset($_POST['insurance_name'])) {
    $insurance_name = $_POST['insurance_name'];
}
if (isset($_POST['company_id'])) {
    $company_id = $_POST['company_id'];
}


$depNme='';
$depStatus='';
$selectinsurance=$con->query("SELECT * FROM insurance_creation WHERE insurance_name = '".$insurance_name."'  and company_id = '".$company_id."'");
if($selectinsurance>0){
	while ($row=$selectinsurance->fetch_assoc()){
		$depNme    = $row["insurance_name"];
		$depStatus  = $row["status"];
	}
}

if($depNme != '' && $depStatus == 0){
	$message="Insurance Already Exists, Please Enter a Different Name!";
}
else if($depNme != '' && $depStatus == 1){
	$updateinsurance=$con->query("UPDATE insurance_creation SET status=0 WHERE insurance_name='".$insurance_name."' and company_id = '".$company_id."' ");
	$message="Insurance Added Succesfully";
}
else{
	if($insurance_id>0){
		$updateinsurance=$con->query("UPDATE insurance_creation SET insurance_name='".$insurance_name."' WHERE insurance_id='".$insurance_id."' and company_id = '".$company_id."' ");
		if($updateinsurance == true){
		    $message="Insurance Updated Succesfully";
	    }
    }
	else{
	    $insertinsurance=$con->query("INSERT INTO insurance_creation(insurance_name,company_id,created_date) VALUES('".strip_tags($insurance_name)."','".strip_tags($company_id)."', current_timestamp() )");
	    if($insertinsurance == true){
		    $message="Insurance Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>