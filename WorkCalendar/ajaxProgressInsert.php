<?php
include '../ajaxconfig.php';

if(isset($_POST['id'])){
    $workdes_id = $_POST['id'];
}
if(isset($_POST['work_name'])){
    $work_name = $_POST['work_name'];
}
if(isset($_POST['remarks'])){
    $remarks = $_POST['remarks'];
}
$work_status = "1"; // in progress

$qry = "INSERT into work_status (work_id, work_des, work_status, remarks, created_date) values ('" . strip_tags($workdes_id) . "','" . strip_tags($work_name) . "', 
'" . strip_tags($work_status) . "', '" . strip_tags($remarks) . "', current_timestamp())  ";  
$result = $con->query($qry) or die("error");

$ifhas = "todo";
$ifhas1 = "krakpi_ref";
$ifhas2 = "audit_area";
$ifhas3 = "maintenance";
$ifhas4 = "campaign";

if (strstr($workdes_id, $ifhas)) {
    //"The substring was found in the string";
    $todo_id = preg_replace('/todo /', '', $workdes_id);
    $qry = "UPDATE todo_creation set work_status = 1 where todo_id = '".$todo_id."' ";
    $result = $con->query($qry) or die("Error Not able to update todo table");
} else if(strstr($workdes_id, $ifhas1)) {
    //"The substring was found in the string";
    $krakpi_ref_id = preg_replace('/krakpi_ref /', '', $workdes_id);
    $qry = "UPDATE krakpi_creation_ref set work_status = 1 where krakpi_ref_id = '".$krakpi_ref_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas2)) {
    //"The substring was found in the string";
    $audit_area_id = preg_replace('/audit_area /', '', $workdes_id);
    $qry = "UPDATE audit_area_creation set work_status = 1 where audit_area_id = '".$audit_area_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas3)) {
    //"The substring was found in the string";
    $maintenance_checklist_id = preg_replace('/maintenance /', '', $workdes_id);
    $qry = "UPDATE maintenance_checklist set work_status = 1 where maintenance_checklist_id = '".$maintenance_checklist_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else if(strstr($workdes_id, $ifhas4)) {
    //"The substring was found in the string";
    $campaign_ref_id = preg_replace('/campaign /', '', $workdes_id);
    $qry = "UPDATE campaign_ref set work_status = 1 where campaign_ref_id = '".$campaign_ref_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
} else {
    //"The substring was not found in the string";
    $qry = "UPDATE assign_work_ref set work_status = 1 where ref_id = '".$workdes_id."' ";
    $result = $con->query($qry) or die("Error Not able to update assign work table");
}
    
echo json_encode($work_status) ;
?>