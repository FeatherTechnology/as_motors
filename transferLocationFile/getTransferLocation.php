<?php 
include('../ajaxconfig.php');

$branchList_arr = array();

if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}
//Get Transfer Location Except selected Branch name.
$result = $connect->query("SELECT branch_id,branch_name FROM `branch_creation` where branch_id !='".$branch_id."' AND status = 0");

while( $row = $result->fetch()){
    $branch_id = $row['branch_id'];
    $branch_name = $row['branch_name'];
    $branchList_arr[] = array("branch_id" => $branch_id, "branch_name" => $branch_name);
}

echo json_encode($branchList_arr);
?>