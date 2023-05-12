<?php
include '../ajaxconfig.php';

if (isset($_POST['designation_id'])) {
    $designation_id = $_POST['designation_id'];
}
if (isset($_POST['designation_name'])) {
    $designation_name = $_POST['designation_name'];
}
if (isset($_POST['branch_id'])) {
    $company_id = $_POST['branch_id'];
}

$depNme='';
$depStatus='';
$selectDesignation=$con->query("SELECT * FROM designation_creation WHERE designation_name = '".$designation_name."' AND company_id = '".$company_id."' ");
while ($row=$selectDesignation->fetch_assoc()){
	$depNme    = $row["designation_name"];
	$depStatus  = $row["status"];
}

if($depNme != '' && $depStatus == 0){
	$message="Designation Already Exists, Please Enter a Different Name!";
}else if($depNme != '' && $depStatus == 1){ 
	$updateDesignation=$con->query("UPDATE designation_creation SET status=0 WHERE designation_name='".$designation_name."' AND company_id = ".$company_id."' ");
	$message="Designation Added Succesfully";
}else{
	if($designation_id>0){
		$updateDesignation=$con->query("UPDATE designation_creation SET designation_name='".$designation_name."' WHERE designation_id='".$designation_id."' 
		AND company_id = '".$company_id."' ");
		if($updateDesignation == true){
		    $message="Designation Updated Succesfully";
	    }
    }
	else{
	    $insertDesignation=$con->query("INSERT INTO designation_creation(designation_name, company_id) VALUES ('".strip_tags($designation_name)."', 
		'".strip_tags($company_id)."')");
	    if($insertDesignation == true){
		    $message="Designation Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>