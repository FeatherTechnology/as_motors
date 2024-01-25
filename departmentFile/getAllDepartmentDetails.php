<?php 
//Also using in kra_kpi_report.js
//Also using in staff_task_details.js
include('../ajaxconfig.php');

$deptList_arr = array();

$result = $connect->query("SELECT dc.department_id, dc.department_name, brc.branch_name FROM `basic_creation` bc LEFT JOIN `department_creation` dc ON bc.department = dc.department_id LEFT JOIN `branch_creation` brc ON bc.company_id = brc.branch_id WHERE bc.status = 0 GROUP BY department_id");
// $result = $connect->query("SELECT dc.department_id, dc.department_name FROM `basic_creation` bc LEFT JOIN `department_creation` dc ON bc.department = dc.department_id GROUP BY department_id");

while( $row = $result->fetch()){
    $department_name = $row['department_name'];
    $department_id = $row['department_id'];
    $branch_name = $row['branch_name'];
    $deptList_arr[] = array("department_id" => $department_id, "department_name" => $department_name, "branch_name" => $branch_name);
}

echo json_encode($deptList_arr);
?>