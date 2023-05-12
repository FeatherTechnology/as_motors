<?php
include('ajaxconfig.php');

if(isset($_POST["prev_checklist"])){
	$prev_chekclist_id  = $_POST["prev_checklist"];
}

$major_area = array();
// $sub_area = array();
$assertion = array();
$weightage = array();

$qry=$con->query("SELECT major_area,assertion,weightage FROM audit_checklist_ref JOIN audit_checklist ON audit_checklist_ref.audit_area_id  = audit_checklist.audit_area_id 
 where audit_checklist.audit_area_id = '".$prev_chekclist_id."'");

while($row=$qry->fetch_assoc()){
    $major_area[] = $row['major_area'];
    // $sub_area[] = $row['sub_area'];
    $assertion[] = $row['assertion'];
    $weightage[] = $row['weightage'];
}

for($i=0;$i<count($major_area); $i++){
    $prevChecklist[$i]['major_area'] = $major_area[$i];
    // $prevChecklist[$i]['sub_area'] = $sub_area[$i];
    $prevChecklist[$i]['assertion'] = $assertion[$i];
    $prevChecklist[$i]['weightage'] = $weightage[$i];
}

echo json_encode($prevChecklist);

?>