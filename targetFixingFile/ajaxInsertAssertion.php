<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_SESSION["curdateFromIndexPage"])){
	$curdate = $_SESSION["curdateFromIndexPage"];
}

if (isset($_POST['assertion_id'])) {
    $assertion_id = $_POST['assertion_id'];
}
if (isset($_POST['assertion'])) {
    $assertion = $_POST['assertion'];
}
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}
if (isset($_POST['dept_id'])) {
    $dept_id = $_POST['dept_id'];
}

$assertionNme='';
$assertionStatus='';
$selectAssertion=$con->query("SELECT * FROM assertion_creation WHERE assertion = '".$assertion."' AND dept_id = '".$dept_id."' ");
while ($row=$selectAssertion->fetch_assoc()){
	$assertionNme    = $row["assertion"];
	$assertionStatus  = $row["status"];
}

if($assertionNme != '' && $assertionStatus == 0){
	$message="Assertion Already Exists, Please Enter a Different Name!";
}else if($assertionNme != '' && $assertionStatus == 1){ 
	$updateAssertion = $con->query("UPDATE assertion_creation SET status=0, updated_date = '$curdate' WHERE assertion='".$assertion."' AND dept_id = '".$dept_id."' ");
	$message="Assertion Added Succesfully";
}else{
	if($assertion_id>0){
		$updateAssertion = $con->query("UPDATE assertion_creation SET assertion='".$assertion."', updated_date = '$curdate'  WHERE assertion_id ='".$assertion_id."' ");
        
		if($updateAssertion){
            $message="Assertion Updated Succesfully";
        }
    }
	else{
        $insertAssertion = $con->query("INSERT INTO assertion_creation(assertion, branch_id, dept_id, created_date) VALUES ('$assertion', '$branch_id', '$dept_id', '$curdate')");
        if($insertAssertion){
            $message="Assertion Added Succesfully";
        }
    }
}

echo json_encode($message);
?>