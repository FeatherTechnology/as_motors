<?php 
include '../ajaxconfig.php';
if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}

$staffDetails = array();
// get staff
$getStaff = $con->query("SELECT * FROM staff_creation WHERE company_id = '".$branch_id."' AND status=0 ORDER BY staff_id DESC");  //In company_id column is storing branch id.
if(mysqli_num_rows($getStaff)>0){
    while($row5 = $getStaff->fetch_assoc()){
        $staff_id[]         = $row5['staff_id']; 
        $staff_name[]       = strip_tags($row5['staff_name']);
        $designation[]       = $row5['designation'];
    }
    $staffDetails["staff_id"] = $staff_id;
    $staffDetails["staff_name"] = $staff_name;
    $staffDetails["designation"] = $designation;
}

echo json_encode($staffDetails);

?>