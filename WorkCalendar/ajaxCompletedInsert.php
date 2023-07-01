<?php
include '../ajaxconfig.php';

if(isset($_POST['id'])){
    $workdes_id = $_POST['id'];
}
if(isset($_POST['work_name'])){
    $work_name = $_POST['work_name'];
}
if(isset($_POST['completed_remark'])){
    $completed_remark = $_POST['completed_remark'];
}
if (isset($_FILES['completed_file'])) {
    
    // File uploading code
    $file = $_FILES['completed_file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $targetPath = '../uploads/completedTaskFile/'.$fileName;
    move_uploaded_file($fileTmpName, $targetPath);
}

$work_status = "3"; // completed
   
$qry = "INSERT into work_status (work_id,work_des,work_status,remarks,completed_file,created_date) values ('" . strip_tags($workdes_id) . "','" . strip_tags($work_name) . "','" . strip_tags($work_status) . "','" . strip_tags($completed_remark) . "','" . strip_tags($fileName) . "', current_timestamp())  ";
$result = $con->query($qry) or die("error");

$ifhas = "todo";
$ifhas1 = "krakpi_ref";
$ifhas2 = "audit_area";
$ifhas3 = "maintenance";
$ifhas4 = "campaign";
$ifhas5 = "insurance";
$ifhas6 = "BM";
$ifhas7 = "FC_INS_renew";

if (strstr($workdes_id, $ifhas)) {
    //"The substring was found in the string";
    $todo_id = preg_replace('/todo /', '', $workdes_id);
    $qry = "UPDATE todo_creation set work_status = 3 where todo_id = '".$todo_id."' ";
    $result = $con->query($qry) or die("Error Not able to update todo table");
} else if(strstr($workdes_id, $ifhas1)) {
    //"The substring was found in the string";
    $krakpi_calendar_map_id = preg_replace('/krakpi_ref /', '', $workdes_id);
    $qry = "UPDATE krakpi_calendar_map set work_status = 3 where krakpi_calendar_map_id = '".$krakpi_calendar_map_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas2)) {
    //"The substring was found in the string";
    $audit_area_id = preg_replace('/audit_area /', '', $workdes_id);
    $qry = "UPDATE audit_area_creation_ref set work_status = 3 where audit_area_creation_ref_id = '".$audit_area_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas3)) {
    //"The substring was found in the string";
    $maintenance_checklist_id = preg_replace('/maintenance /', '', $workdes_id);
    $qry = "UPDATE pm_checklist_ref set work_status = 3 where pm_checklist_ref_id = '".$maintenance_checklist_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas4)) {
    //"The substring was found in the string";
    $campaign_ref_id = preg_replace('/campaign /', '', $workdes_id);
    $qry = "UPDATE campaign_ref set work_status = 3 where campaign_ref_id = '".$campaign_ref_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas5)) {
    //"The substring was found in the string";
    $ins_reg_ref_id = preg_replace('/insurance /', '', $workdes_id);
    $qry = "UPDATE insurance_register_ref set work_status = 3 where ins_reg_ref_id = '".$ins_reg_ref_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas6)) {
    //"The substring was found in the string";
    $maintenance_checklist_id_bm = preg_replace('/BM /', '', $workdes_id);
    $qry = "UPDATE bm_checklist_ref set work_status = 3 where bm_checklist_ref_id = '".$maintenance_checklist_id_bm."' ";
    $result = $con->query($qry) or die("Error Not able to update BM Checklist ref table");
} else if(strstr($workdes_id, $ifhas7)) {
    //"The substring was found in the string";
    $Fc_insurance_renew_id = preg_replace('/FC_INS_renew /', '', $workdes_id);
    $qry = "UPDATE fc_insurance_renew set work_status = 3 where Fc_insurance_renew_id = '".$Fc_insurance_renew_id."' ";
    $result = $con->query($qry) or die("Error Not able to update FC Insurance Renew table");
} else {
    //"The substring was not found in the string";
    $assign_wrk_ref_id = preg_replace('/assign_work /', '', $workdes_id);
    $qry = "UPDATE assign_work_ref set work_status = 3 where ref_id = '".$assign_wrk_ref_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
}
    
echo json_encode($work_status) ;
?>