<?php
include('../ajaxconfig.php');

if(isset($_POST["date_of_audit"])){
    $date_of_audit  = $_POST["date_of_audit"];
}

$qry1=$con->query("SELECT * FROM audit_area_creation WHERE DATE(from_date) <= '".$date_of_audit."' AND DATE(to_date) >= '".$date_of_audit."' AND status = '0' ");
$row1=$qry1->fetch_assoc();
$dept_id = $row1['department_id'];
$role1_id = $row1['role1'];
$role2_id = $row1['role2'];
$dept_name = array();

// get department by id
$departmentId1 = explode(",", $dept_id);
foreach($departmentId1 as $departmentId) {
    $departmentId = trim($departmentId);
    $getqry1 = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentId)."' AND status = 0";
    $res13 = $con->query($getqry1);
    while($row2 = $res13->fetch_assoc())
    {
       $dept_name[] = $row2["department_name"];
    }
}
$message['dept_id'] = $departmentId1;

$qry3=$con->query("SELECT * FROM designation_creation WHERE designation_id= '".$role1_id."'");
// SELECT * FROM staff_creation WHERE staff_id = '".$role1_id."' 
$row3=$qry3->fetch_assoc();
$auditor_name = $row3['designation_name'];
$role1_id = $row3['designation_id'];

// get role 2 by id
$qry4=$con->query("SELECT * FROM designation_creation WHERE designation_id= '".$role2_id."'");
    $row4=$qry4->fetch_assoc();
    $auditee_name = $row4['designation_name'];
    $role2_id = $row4['designation_id'];
    $message['dept'] = $dept_name;
    $message['role1'] = $auditor_name;
    $message['role1_id'] = $role1_id;
    $message['role2'] = $auditee_name;
    $message['role2_id'] = $role2_id;

// check audit area already given
$qry5 = $con->query("SELECT * FROM audit_checklist_ref WHERE DATE(from_date) <= '".$date_of_audit."' AND DATE(to_date) >= '".$date_of_audit."' AND status = '0' ");
$message['exist']='';
if($con->affected_rows>0){
    $message['exist']="Selected Audit Area already submitted. Please Use Previous Checklist";
}else{
    $message['exist']='';
}
echo json_encode($message);
?>