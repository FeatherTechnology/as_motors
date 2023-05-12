<?php
include '../ajaxconfig.php';

if (isset($_POST['spare_name'])) {
    $spare_name = $_POST['spare_name'];
	
}
if (isset($_POST['spare_id'])) {
    $spare_id = $_POST['spare_id'];
}
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}
if (isset($_POST['company_id'])) {
    $company_id = $_POST['company_id'];
}

$spareNme='';
$spareStatus='';
$selectSpare=$con->query("SELECT * FROM spare_creation WHERE spare_name = '".$spare_name."' and branch_id = '".$branch_id."' ");
if($selectSpare>0){
	while ($row=$selectSpare->fetch_assoc()){
		$spareNme    = $row["spare_name"];
		$spareStatus  = $row["status"];
	}
}
// print_r($spareNme,$spareStatus);
// die();
if($spareNme != '' && $spareStatus == 0){
	$message="Spare Name Already Exists, Please Enter a Different Name!";
}
else if($spareNme != '' && $spareStatus == 1){
	$updateDepartment=$con->query("UPDATE spare_creation SET status=0 WHERE spare_name='".$spare_name."' and branch_id = '".$branch_id."' ");
	$message="Spare Name Updated Succesfully";
}
else{
	if($spare_id>0){
		$updateDepartment=$con->query("UPDATE spare_creation SET spare_name='".$spare_name."' WHERE spare_id='".$spare_id."' and branch_id = '".$branch_id."'");
		if($updateDepartment == true){
		    $message="Spare Name Updated Succesfully";
	    }
    }
	else{
	    $insertDepartment=$con->query("INSERT INTO spare_creation(spare_name, branch_id, company_id, created_date) 
        VALUES('".strip_tags($spare_name)."', '".strip_tags($branch_id)."', '".strip_tags($company_id)."', current_timestamp())");
	    if($insertDepartment == true){
		    $message="Spare Name Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>