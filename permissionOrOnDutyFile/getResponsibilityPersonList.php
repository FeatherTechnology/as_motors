<?php
include '../ajaxconfig.php';

if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}
if(isset($_POST["department"])){
	$department = $_POST["department"];
}
if(isset($_POST["resUserRole"])){
	$resUserRole = $_POST["resUserRole"];
}

$staff_id = array();
$staff_name = array();
$designation_name = array();

if($resUserRole == '4'){ //if staff login then responsible staff has to show they department staff list only
    $getInstName=$con->query("SELECT sc.staff_id, sc.staff_name, dc.designation_name FROM staff_creation sc LEFT JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE sc.department = '$department' AND sc.status = 0");

}else{ //ifnot a staff login then show branch based staff list 
    $getInstName=$con->query("SELECT sc.staff_id, sc.staff_name, dc.designation_name FROM staff_creation sc LEFT JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE sc.company_id = '$branch_id' AND sc.status = 0");

}
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
    $designation_name[]    = $row2["designation_name"];
} 

$staffDetails["staff_id"] = $staff_id;
$staffDetails["staff_name"] = $staff_name;
$staffDetails["designation_name"] = $designation_name;
    
echo json_encode($staffDetails);
?>