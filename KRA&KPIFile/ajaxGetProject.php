<?php 
include('../ajaxconfig.php');

$project_arr = array();
$result=$con->query("SELECT * FROM project_creation where 1 and status=0");
while( $row = $result->fetch_assoc()){
    $project_id = $row['project_id'];
    $project_name = $row['project_name'];
    $project_arr[] = array("project_id" => $project_id, "project_name" => $project_name);
}

echo json_encode($project_arr);
?>