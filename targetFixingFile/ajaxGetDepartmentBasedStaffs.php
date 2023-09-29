<?php 
include('../ajaxconfig.php');
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"];
}

$staff_id = array();
$staff_name = array();
$emp_code = array();

$getstaffDetails = $con->query("SELECT tl.transfer_effective_from, sch.staff_id, sch.staff_name, sch.emp_code FROM `transfer_location` tl LEFT JOIN staff_creation_history sch ON tl.transfer_location_id = sch.transfer_location_id WHERE tl.department_id = '$department_id' ");
if(mysqli_num_rows($getstaffDetails)>0){
    while($staffInfo = $getstaffDetails->fetch_assoc()){
        $transfer_effective_from = date('Y-m-d',strtotime($staffInfo['transfer_effective_from'])); 
        $curdates = date('Y-m-d');

        if($transfer_effective_from > $curdates){ //Take the staff ID until the effective date yet to start.  
            $staff_id[]     = $staffInfo['staff_id']; //staff id.    
            $staff_name[]   = $staffInfo['staff_name']; //staff name.    
            $emp_code[]     = $staffInfo['emp_code']; //staff code.    
        }
    }
}

$getInstName=$con->query("SELECT * FROM staff_creation WHERE department = '".strip_tags($department_id)."' AND status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]  = $row2["staff_name"];
    $emp_code[]    = $row2["emp_code"];
} 

$departmentDetails["staff_id"] = $staff_id;
$departmentDetails["staff_name"] = $staff_name;
$departmentDetails["emp_code"] = $emp_code;
    
echo json_encode($departmentDetails);
?>