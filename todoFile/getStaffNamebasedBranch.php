<?php 
include '../ajaxconfig.php';
if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}

$staffDetails = array();
// get staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE company_id = '".$branch_id."' AND status=0 ORDER BY staff_id DESC");  //In company_id column is storing branch id.
while($row5 = $getStaff->fetch_assoc()){
    $staff_id[]         = $row5['staff_id']; 
    $staff_name[]       = strip_tags($row5['staff_name']);
}
$staffDetails["staff_id"] = $staff_id;
$staffDetails["staff_name"] = $staff_name;

echo json_encode($staffDetails);

?>