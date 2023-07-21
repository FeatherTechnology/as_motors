<?php 
include('../ajaxconfig.php');

$deptList_arr = array();

$result = $connect->query("SELECT dc.department_id, dc.department_name FROM `basic_creation` bc LEFT JOIN `department_creation` dc ON bc.department = dc.department_id GROUP BY department_id");

while( $row = $result->fetch()){
    $department_name = $row['department_name'];
    $department_id = $row['department_id'];
    $deptList_arr[] = array("department_id" => $department_id, "department_name" => $department_name);
}

echo json_encode($deptList_arr);
?>