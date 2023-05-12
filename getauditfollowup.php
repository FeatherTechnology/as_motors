<?php
include('ajaxconfig.php');

if(isset($_POST["prev_checklist"])){
	$prev_chekclist_id  = $_POST["prev_checklist"];
    // print_r($prev_chekclist_id);
}
if(isset($_POST["date"])){
	$current_date  = $_POST["date"];
    // print_r($current_date);
}

$audit_assign_id = array();
$assertion = array();
$recommendation = array();
$attachment = array();
$auditee_response = array();
$action_plan = array();
$target_date = array();
$audit_status = array();
$department_id = array();
$role1 = array();
$designation_name1 = array();
$role2 = array();
$designation_name2 = array();

$qry=$con->query("SELECT aai.audit_assign_id, aai.assertion, aai.audit_remarks, aai.recommendation, aai.attachment, aai.auditee_response, aai.action_plan, aai.target_date, aai.audit_status,aa.department_id,aa.role1,ds.designation_name AS designation_name1,aa.role2,dsc.designation_name AS designation_name2
FROM audit_assign_ref aai
LEFT JOIN audit_assign aa ON aa.audit_assign_id = aai.audit_assign_id
LEFT JOIN designation_creation ds ON ds.designation_id = aa.role1
LEFT JOIN designation_creation dsc ON dsc.designation_id = aa.role2

WHERE aai.auditee_response_status = '1'
  AND aa.audit_area_id = 1
  AND aai.target_date >= DATE_ADD(CURDATE(), INTERVAL 3 DAY)");

while($row=$qry->fetch_assoc()){
    $audit_assign_id[] = $row['audit_assign_id'];
    $assertion[] = $row['assertion'];
    $audit_remarks[] = $row['audit_remarks'];
    $recommendation[] = $row['recommendation'];
    $attachment[] = $row['attachment'];
    $auditee_response[] = $row['auditee_response'];
    $action_plan[] = $row['action_plan'];
    $target_date[]= $row['target_date'];
    $audit_status[]= $row['audit_status']; 
    $department_id[]= $row['department_id'];
    $role1[]= $row['role1'];
    $designation_name1[]= $row['designation_name1']; 
    $role2[]= $row['role2']; 
    $designation_name2[]= $row['designation_name2'];
    
   
}

for($i=0;$i<count($audit_assign_id); $i++){
    $prevChecklist[$i]['audit_assign_id'] = $audit_assign_id[$i];
    $prevChecklist[$i]['assertion'] = $assertion[$i];
    $prevChecklist[$i]['audit_remarks'] = $audit_remarks[$i];
    $prevChecklist[$i]['recommendation'] = $recommendation[$i];
    $prevChecklist[$i]['attachment'] = $attachment[$i];
    $prevChecklist[$i]['auditee_response'] = $auditee_response[$i];
    $prevChecklist[$i]['action_plan'] = $action_plan[$i];
    $prevChecklist[$i]['target_date'] = $target_date[$i];
    $prevChecklist[$i]['audit_status'] = $audit_status[$i];
    $prevChecklist[$i]['department_id'] = $department_id[$i];
    $prevChecklist[$i]['role1'] = $role1[$i];
    $prevChecklist[$i]['designation_name1'] = $designation_name1[$i];
    $prevChecklist[$i]['role2'] = $role2[$i];
    $prevChecklist[$i]['designation_name2'] = $designation_name2[$i];
}

echo json_encode($prevChecklist);

?>