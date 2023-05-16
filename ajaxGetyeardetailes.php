<?php
include('ajaxconfig.php');

if(isset($_POST["prevyear"])){
    $prevyear  = $_POST["prevyear"];
    

}

$qry1=$con->query("SELECT * FROM audit_area_creation WHERE DATE(from_date) <= '".$date_of_audit."' AND DATE(to_date) >= '".$date_of_audit."' AND status = '0' ");
$row1=$qry1->fetch_assoc();
$dept_id = $row1['department_id'];
$role1_id = $row1['role1'];
$role2_id = $row1['role2'];

// SELECT year_id,year AS prev_year FROM year_creation
// // get role 2 by id
// $qry4=$con->query("SELECT * FROM designation_creation WHERE designation_id= '".$role2_id."'");
//     $row4=$qry4->fetch_assoc();
//     $auditee_name = $row4['designation_name'];
//     $role2_id = $row4['designation_id'];
//     $message['dept'] = $dept_name;
//     $message['role1'] = $auditor_name;
//     $message['role1_id'] = $role1_id;
//     $message['role2'] = $auditee_name;
//     $message['role2_id'] = $role2_id;

// // check audit area already given
// $qry5 = $con->query("SELECT * FROM audit_checklist_ref WHERE DATE(from_date) <= '".$date_of_audit."' AND DATE(to_date) >= '".$date_of_audit."' AND status = '0' ");
// $message['exist']='';
// if($con->affected_rows>0){
//     $message['exist']="Selected Audit Area already submitted. Please Use Previous Checklist";
// }else{
//     $message['exist']='';
// }

// echo json_encode($message);
?>