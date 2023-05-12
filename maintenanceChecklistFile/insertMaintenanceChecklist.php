<?php
include '../ajaxconfig.php';
@session_start();
date_default_timezone_set('Asia/Calcutta');
$current_time = date('H:i:s');

if(isset($_POST['company_id'])){
    $company_id = $_POST['company_id'];
}
if(isset($_POST['doi'])){
    $doi = $_POST['doi'];
}
if(isset($_POST['asset_details'])){
    $asset_details = $_POST['asset_details'];
}
if(isset($_POST['checklist'])){
    $checklist = $_POST['checklist'];
}
if(isset($_POST['calendar'])){
    $calendar = $_POST['calendar'];
}
if(isset($_POST['from_date'])){
    $from_date1 = $_POST['from_date'];
}
if(isset($_POST['to_date'])){
    $to_date1 = $_POST['to_date'];
}
if(isset($_POST['role1'])){
    $role1 = $_POST['role1'];
}
if(isset($_POST['role2'])){
    $role2 = $_POST['role2'];
}
if(isset($_POST['checkedid'])){
    $checkedid = $_POST['checkedid'];
    $checkedidStr = implode(',', $checkedid);
}
if(isset($_POST['remarks'])){
    $remarks = $_POST['remarks'];
    $remarksStr = implode(',', $remarks);
}

if($calendar == "No"){
    $from_date = '';
    $to_date = '';
} else {
    $from_date = $from_date1.' '.$current_time;
    $to_date = $to_date1.' '.$current_time;
}

if(isset($_FILES['file'])){ 

    $files = $_FILES['file']; 
    foreach ($files['name'] as $index => $name) { 
        $file[] = $files['name'][$index];
        $file_name = $files['name'][$index];
        $checklistfile_tmp = $files['tmp_name'][$index];
        $maintenanceChecklistfilefolder="../uploads/maintenance_checklist/".$file_name;
        move_uploaded_file($checklistfile_tmp, $maintenanceChecklistfilefolder);
    }
} else {
    $file='';
}

$checkedidArr = array_map('intval', explode(',', $checkedidStr)); 
$remarksArr = array_map('strval', explode(',', $remarksStr)); 

if($checklist == 'pm_checklist'){ 

    $insertChecklist = "INSERT INTO maintenance_checklist(company_id, date_of_inspection, role1, asset_details, checklist, role2, calendar, from_date, to_date)
    VALUES ('".strip_tags($company_id)."', '".strip_tags($doi)."', '".strip_tags($role1)."', '".strip_tags($asset_details)."', '".strip_tags($checklist)."', 
    '".strip_tags($role2)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."', '".strip_tags($to_date)."' )"; 
    $insertChecklistRun = $con->query($insertChecklist);
    $checklistId = $con->insert_id;

    for($i=0; $i<=sizeof($checkedidArr)-1; $i++){
        $insertChecklistRef = "INSERT INTO maintenance_checklist_ref(maintenance_checklist_id, pm_checklist_id, remarks, file)
        VALUES ('".strip_tags($checklistId)."', '".strip_tags($checkedidArr[$i])."', '".strip_tags($remarksArr[$i])."', '".strip_tags($file[$i])."')"; 
        $insertChecklistRefRun = $con->query($insertChecklistRef);

        $updateQry = 'UPDATE pm_checklist SET maintenance_checklist = 1 WHERE pm_checklist_id = "'.strip_tags($checkedidArr[$i]).'" ';
        $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
    }

}else if($checklist == 'bm_checklist'){
    
    $insertChecklist = "INSERT INTO maintenance_checklist(company_id, date_of_inspection, role1, asset_details, checklist, role2, calendar, from_date, to_date)
    VALUES ('".strip_tags($company_id)."', '".strip_tags($doi)."', '".strip_tags($role1)."', '".strip_tags($asset_details)."', '".strip_tags($checklist)."', 
    '".strip_tags($role2)."', '".strip_tags($calendar)."', '".strip_tags($from_date)."', '".strip_tags($to_date)."' )"; 
    $insertChecklistRun = $con->query($insertChecklist);
    $checklistId = $con->insert_id;

    for($i=0; $i<=sizeof($checkedidArr)-1; $i++){
        $insertChecklistRef = "INSERT INTO maintenance_checklist_ref(maintenance_checklist_id, bm_checklist_id, remarks, file)
        VALUES ('".strip_tags($checklistId)."', '".strip_tags($checkedidArr[$i])."', '".strip_tags($remarksArr[$i])."', '".strip_tags($file[$i])."')"; 
        $insertChecklistRefRun = $con->query($insertChecklistRef);

        $updateQry = 'UPDATE bm_checklist SET maintenance_checklist = 1 WHERE bm_checklist_id = "'.strip_tags($checkedidArr[$i]).'" ';
        $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 
    }
}

if($insertChecklist){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);

?>