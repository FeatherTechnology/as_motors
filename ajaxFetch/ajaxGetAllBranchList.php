<?php
//Also Using in 'vehicle_report.js'.
include '../ajaxconfig.php';

$branch_names = array();
$getct = "SELECT * FROM branch_creation WHERE status=0";
$result = $con->query($getct);

while($row=$result->fetch_assoc())
{
    $branch_name = $row['branch_name'];
    $branch_id = $row['branch_id'];

    $branch_names[] = array("branch_id" => $branch_id, "branch_name" => $branch_name);
}

echo json_encode($branch_names);
?>