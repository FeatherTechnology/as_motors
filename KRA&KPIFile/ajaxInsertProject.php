<?php
include '../ajaxconfig.php';

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];
}
if (isset($_POST['project_name'])) {
    $project_name = $_POST['project_name'];
}

$crsNme='';
$crsStatus='';
$selectCategory=$con->query("SELECT * FROM project_creation WHERE project_name = '".$project_name."' ");
while ($row=$selectCategory->fetch_assoc()){
	$crsNme    = $row["project_name"];
	$crsStatus  = $row["status"];
}

if($crsNme != '' && $crsStatus == 0){
	$message="Project Already Exists, Please Enter a Different Name!";
}
else if($crsNme != '' && $crsStatus == 1){
	$updateProject=$con->query("UPDATE project_creation SET status=0 WHERE project_name='".$project_name."' ");
	$message="Project Added Succesfully";
}
else{
	if($project_id>0){ 
		$updateProject= "UPDATE project_creation SET project_name='".$project_name."' WHERE project_id='".$project_id."' "; 
		if($updateProject == true){
		    $message="Project Updated Succesfully";
	    }
    }
	else{
	    $insertProject=$con->query("INSERT INTO project_creation(project_name) VALUES('".strip_tags($project_name)."')");
	    if($insertProject == true){
		    $message="Project Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>