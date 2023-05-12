<?php
include('ajaxconfig.php');
if(isset($_POST["audit_id"])){
    $audit_id  = $_POST["audit_id"];
}
$qry1=$con->query("SELECT * FROM audit_area_creation WHERE audit_area_id= '$audit_id'");
    $row1=$qry1->fetch_assoc();
    $dept_id = $row1['department_id'];
    $auditor_id = $row1['role1'];
    $auditee_id = $row1['role2'];
   

$dept_name = array();
//get department by id
$departmentId1 = explode(",", $dept_id);
foreach($departmentId1 as $departmentId) {
    $departmentId = trim($departmentId);
    $getqry1 = "SELECT department_name FROM department_creation WHERE department_id IN ($departmentId) AND status = 0;";
    // SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentId)."' AND status = 0
    $res13 = $con->query($getqry1);
    while($row2 = $res13->fetch_assoc())
    {
       $dept_name[] = $row2["department_name"];
    }
}
$message['dept_id'] = $departmentId1;
// $qry2=$con->query("select * from department_creation where department_id = '".$dept_id."' ");
//     $row2=$qry2->fetch_assoc();
//     $dept_name = $row2['department_name'];
//get Auditor by id

$qry3=$con->query("SELECT * FROM designation_creation WHERE designation_id= '".$auditor_id."'");

// select * from staff_creation where staff_id = '".$auditor_id."' 
    $row3=$qry3->fetch_assoc();
    $auditor_name = $row3['designation_name'];
    $auditor_id = $row3['designation_id'];
//get Auditee by id
$qry4=$con->query("SELECT * FROM designation_creation WHERE designation_id= '".$auditee_id."'");
// select * from staff_creation where staff_id = '".$auditee_id."' 
    $row4=$qry4->fetch_assoc();
    $auditee_name = $row4['designation_name'];
    $auditee_id = $row4['designation_id'];
    $message['dept'] = $dept_name;
    $message['auditor'] = $auditor_name;
    $message['auditor_id'] = $auditor_id;
    $message['auditee'] = $auditee_name;
    $message['auditee_id'] = $auditee_id;
//check audit area already given
$qry5 = $con->query("select * from audit_checklist_ref where audit_area_id= '".$audit_id."'");
$message['exist']='';
if($con->affected_rows>0){
    $message['exist']="Selected Audit Area already submitted. Please Use Previous Checklist";
}else{
    $message['exist']='';
}
echo json_encode($message);
?>