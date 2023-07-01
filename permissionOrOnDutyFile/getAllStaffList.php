<?php
include '../ajaxconfig.php';

$staff_id = array();
$staff_name = array();
$designation_name = array();

$getInstName=$con->query("SELECT a.staff_id, a.staff_name, b.designation_name FROM staff_creation a LEFT JOIN designation_creation b ON a.designation = b.designation_id WHERE a.status = 0");
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