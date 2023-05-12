<?php
@session_start();
include('../ajaxconfig.php');

if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];  
}

$StaffDetails = array();
$department = '';
$staff_name ='';

$getposmember= $con->query("SELECT * FROM staff_creation WHERE staff_id = '".$staffid."' "); 
if($getposmember->num_rows>0){
    while($row=$getposmember->fetch_assoc()){ 

        $department=$row["department"];   
        $staff_name=$row["staff_name"];   
        $staff_id=$row["staff_id"]; 
            
    }
}
$getpos= $con->query("SELECT * FROM department_creation WHERE department_id = '".$department."' "); 
if($getpos->num_rows>0){
    while($row=$getpos->fetch_assoc()){ 

        $department=$row["department_name"];   
                            
    }
} 

$StaffDetails['staff_name'] = $staff_name;
$StaffDetails['department'] = $department;

echo json_encode($StaffDetails);
?>
