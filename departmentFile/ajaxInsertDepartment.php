<?php
include '../ajaxconfig.php';

if (isset($_POST['department_id'])) {
    $department_id = $_POST['department_id'];
}
if (isset($_POST['department_name'])) {
    $department_name = $_POST['department_name'];
}
if (isset($_POST['branch_id'])) {
    $company_id = $_POST['branch_id'];
}

$depNme='';
$depStatus='';
$selectDepartment=$con->query("SELECT * FROM department_creation WHERE department_name = '".$department_name."' and company_id = '".$company_id."' ");
if($selectDepartment>0){
	while ($row=$selectDepartment->fetch_assoc()){
		$depNme    = $row["department_name"];
		$depStatus  = $row["status"];
	}
}

if($depNme != '' && $depStatus == 0){
	$message="Department Already Exists, Please Enter a Different Name!";
}
else if($depNme != '' && $depStatus == 1){
	$updateDepartment=$con->query("UPDATE department_creation SET status=0 WHERE department_name='".$department_name."' and company_id = '".$company_id."' ");
	$message="Department Added Succesfully";
}
else{
	if($department_id>0){
		$updateDepartment=$con->query("UPDATE department_creation SET department_name='".$department_name."' WHERE department_id='".$department_id."' and company_id = '".$company_id."' ");
		if($updateDepartment == true){
		    $message="Department Updated Succesfully";
	    }
    }
	else{
	    $insertDepartment=$con->query("INSERT INTO department_creation(department_name, company_id) VALUES('".strip_tags($department_name)."', '".strip_tags($company_id)."')");
	    if($insertDepartment == true){
		    $message="Department Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>