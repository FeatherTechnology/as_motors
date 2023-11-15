<?php
include '../ajaxconfig.php';
@session_start();

if(isset($_SESSION["curdateFromIndexPage"])){
	$curdate = $_SESSION["curdateFromIndexPage"];
}

if (isset($_POST['responsibility_id'])) {
    $responsibility_id = $_POST['responsibility_id'];
}
if (isset($_POST['responsible_name'])) {
    $responsibility_name = $_POST['responsible_name'];
}
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}

$resNme='';
$resStatus='';
$selectRes=$con->query("SELECT * FROM responsibility_creation WHERE responsibility_name = '".$responsibility_name."' AND branch_id = '".$branch_id."' ");
while ($row=$selectRes->fetch_assoc()){
	$resNme    = $row["responsibility_name"];
	$resStatus  = $row["status"];
}

if($resNme != '' && $resStatus == 0){
	$message="Responsibility Already Exists, Please Enter a Different Name!";
}else if($resNme != '' && $resStatus == 1){ 
	$updateDesignation=$con->query("UPDATE responsibility_creation SET status=0, updated_date = '$curdate' WHERE responsibility_name='".$responsibility_name."' AND branch_id = '".$branch_id."' ");
	$message="Responsibility Added Succesfully";
}else{
	if($responsibility_id>0){
		$updateDesignation=$con->query("UPDATE responsibility_creation SET responsibility_name='".$responsibility_name."', updated_date = '$curdate'  WHERE responsibility_id='".$responsibility_id."' AND branch_id = '".$branch_id."' ");
        
		if($updateDesignation == true){
            $message="Responsibility Updated Succesfully";
        }
    }
	else{
        $insertDesignation=$con->query("INSERT INTO responsibility_creation(responsibility_name, branch_id, created_date) VALUES ('".strip_tags($responsibility_name)."', '".strip_tags($branch_id)."', '$curdate')");
        if($insertDesignation == true){
            $message="Responsibility Added Succesfully";
        }
    }
}

echo json_encode($message);
?>