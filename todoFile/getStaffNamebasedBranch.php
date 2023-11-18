<?php 
//Using in TODO, Daily Task Update.
include '../ajaxconfig.php';
if(isset($_POST["branch_id"])){
	$branch_id = $_POST["branch_id"];
}

$staffDetails = array();
// get staff
if($branch_id == '0'){
    $getStaff = $con->query("SELECT sc.staff_id, sc.staff_name, sc.designation, dc.designation_name FROM staff_creation sc JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE sc.status=0 ORDER BY sc.staff_id DESC");  //branch id is storing in company_id column instead of company id .

}else{
    $getStaff = $con->query("SELECT sc.staff_id, sc.staff_name, sc.designation, dc.designation_name FROM staff_creation sc JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE sc.company_id = '".$branch_id."' AND sc.status=0 ORDER BY sc.staff_id DESC");  //branch id is storing in company_id column instead of company id .

}
if(mysqli_num_rows($getStaff)>0){
    while($row5 = $getStaff->fetch_assoc()){
        $staff_id[]         = $row5['staff_id']; 
        $staff_name[]       = strip_tags($row5['staff_name']);
        $designation[]       = $row5['designation'];
        $designationName[]       = $row5['designation_name'];
    }
    $staffDetails["staff_id"] = $staff_id;
    $staffDetails["staff_name"] = $staff_name;
    $staffDetails["designation"] = $designation;
    $staffDetails["designationName"] = $designationName;
}

echo json_encode($staffDetails);

?>