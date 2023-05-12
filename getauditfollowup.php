<?php
include('ajaxconfig.php');

if(isset($_POST["prev_checklist"])){
	$prev_chekclist_id  = $_POST["prev_checklist"];
    print_r($prev_chekclist_id);
}
if(isset($_POST["date"])){
	$current_date  = $_POST["date"];
    print_r($current_date);
}

$major_area = array();
// $sub_area = array();
$assertion = array();
$weightage = array();

$qry=$con->query("SELECT aai.audit_assign_id, aai.assertion, aai.audit_remarks, aai.recommendation, aai.attachment, aai.auditee_response, aai.action_plan, aai.target_date, aai.audit_status
FROM audit_assign_ref aai
LEFT JOIN audit_assign aa ON aa.audit_assign_id = aai.audit_assign_id
WHERE aai.auditee_response_status = '1'
  AND aa.audit_area_id = $prev_chekclist_id
  AND aai.target_date >= DATE_ADD(CURDATE(), INTERVAL 3 DAY);");
// SELECT aai.audit_assign_id,aai.assertion,aai.audit_remarks,aai.recommendation,aai.attachment,aai.auditee_response,aai.action_plan,aai.target_date,aai.audit_status FROM audit_assign_ref aai LEFT JOIN audit_assign aa ON aa.audit_assign_id = aai.audit_assign_id WHERE  aai.auditee_response_status='0' AND aa.audit_area_id='$prev_chekclist_id' AND aai.target_date NOT IN ('NULL');
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
    
   
}

for($i=0;$i<count($major_area); $i++){
    $prevChecklist[$i]['major_area'] = $major_area[$i];
    // $prevChecklist[$i]['sub_area'] = $sub_area[$i];
    $prevChecklist[$i]['assertion'] = $assertion[$i];
    $prevChecklist[$i]['weightage'] = $weightage[$i];
}

echo json_encode($prevChecklist);

?>