<?php
include '../ajaxconfig.php';
// Also using in Campaign.js page

if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"];
}

$stafftList_arr = array();
// $getInstName=$con->query("SELECT * FROM staff_creation WHERE department = '".strip_tags($department_id)."' AND status = 0");
$getInstName=$con->query("SELECT a.staff_id, a.staff_name, b.designation_name, a.emp_code FROM staff_creation a LEFT JOIN designation_creation b ON a.designation = b.designation_id WHERE a.department = '".strip_tags($department_id)."' AND a.status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id    = $row2["staff_id"];
    $staff_name    = $row2["staff_name"];
    $emp_code    = $row2["emp_code"];
    $designation_name    = $row2["designation_name"];

    $stafftList_arr[] = array("staff_id" => $staff_id, "staff_name" => $staff_name, "emp_code" => $emp_code, "designation_name" => $designation_name);
} 
    
echo json_encode($stafftList_arr);
?>