<?php
@session_start();
include '../ajaxconfig.php';

$staff_id = array();
$staff_name = array();

$getInstName=$con->query("SELECT * FROM staff_creation WHERE 1 AND status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
} 

$staffDetails["staff_id"] = $staff_id;
$staffDetails["staff_name"] = $staff_name;
    
echo json_encode($staffDetails);
?>