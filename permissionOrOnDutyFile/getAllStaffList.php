<?php
//Also Using this page in work_status_report.php for staff List. 
include '../ajaxconfig.php';

$staff_id = array();
$staff_name = array();
$designation_name = array();
$emp_code = array();

$getInstName=$con->query("SELECT a.staff_id, a.staff_name, b.designation_name, a.emp_code FROM staff_creation a LEFT JOIN designation_creation b ON a.designation = b.designation_id WHERE a.status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
    $designation_name[]    = $row2["designation_name"];
    $emp_code[]    = $row2["emp_code"];
} 

$staffDetails["staff_id"] = $staff_id;
$staffDetails["staff_name"] = $staff_name;
$staffDetails["designation_name"] = $designation_name;
$staffDetails["emp_code"] = $emp_code;
    
echo json_encode($staffDetails);
?>