<?php
include('../ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}
if(isset($_SESSION["designation_id"])){
    $designation = $_SESSION["designation_id"];
}else{
    $designation = 0;
}
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}else{
    $staffid = 0;
}

$column = array(
    
    'bm_checklist_id',
    'company_id',
    'category_id',
    'checklist',
    'rating	',
    'status'
);

//krakpi
//audit
//maintance
//bm
//Campaign
//Assign Work

$workid = array();
$mapid = array();
$tasktitle = array();
$worksts = array();

$rr = array();
$kpi = array();
$checkqry = $con->query("SELECT kcr.rr, kcr.kpi FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm. krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0  AND kc.designation = '".$designation."' AND kcm.work_status IN (0, 1, 2) AND ( CURDATE() >= DATE(kcm.from_date) AND CURDATE() <= DATE(kcm.to_date) )");
while($row = $checkqry->fetch_assoc()){
    $rr[] = $row["rr"];
    $kpi[] = $row["kpi"];
}

$qry = "";

$qry = "SELECT 'KRA & KPI' as work_id, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts,
            CASE
                WHEN kcr.rr = 'New' THEN kcr.kpi
                ELSE rrr.rr
            END as title
        FROM krakpi_calendar_map kcm
        LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id
        LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id
        LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
        WHERE kc.status = 0 
        AND kc.designation = '".$designation."' 
        AND kcm.work_status IN (0, 1, 2) 
        AND (CURDATE() >= DATE(kcm.from_date) AND CURDATE() <= DATE(kcm.to_date))";

$krakpiInfo = $connect->query($qry);
if($krakpiInfo){
    
while ($krakpitask = $krakpiInfo->fetch()) { 
    $mapid[]['id'] = $krakpitask['id'];
    $workid[]['work_id'] = $krakpitask['work_id'];
    $tasktitle[]['title'] = $krakpitask['title'];
    $worksts[]['sts'] = $krakpitask['sts'];
    }
}

$auditTaskInfo ="SELECT 'AUDIT ' as work_id, acr.audit_area_creation_ref_id as id, acr.work_status as sts, ac.audit_area  as title
FROM audit_area_creation_ref acr LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id WHERE ac.status = 0 AND acr.work_status IN (0, 1, 2) AND (ac.role1 = '".$designation."' OR ac.role2 = '".$designation."') AND ( CURDATE() >= DATE(acr.from_date) AND CURDATE() <= DATE(acr.to_date) )";
$auditInfo = $connect->query($auditTaskInfo);
if($auditInfo){
    
while ($audittask = $auditInfo->fetch()) { 
    $mapid[]['id'] = $audittask['id'];
    $workid[]['work_id'] = $audittask['work_id'];
    $tasktitle[]['title'] = $audittask['title'];
    $worksts[]['sts'] = $audittask['sts'];
}   
}            

$maintanceTaskInfo = "SELECT 'MAINTENANCE '  as work_id, pcr.pm_checklist_ref_id as id, pcr.work_status as sts, pcr.checklist as title
FROM pm_checklist_ref pcr LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id WHERE mc.status = 0 AND pcr.work_status IN (0, 1, 2) AND (mc.role1 = '".$designation."' OR mc.role2 = '".$designation."') AND ( CURDATE() >= DATE(pcr.from_date) AND CURDATE() <= DATE(pcr.to_date) )";
$maintanceInfo = $connect->query($maintanceTaskInfo);
if($maintanceInfo){
while ($maintancetask = $maintanceInfo->fetch()) { 
    $mapid[]['id'] = $maintancetask['id'];
    $workid[]['work_id'] = $maintancetask['work_id'];
    $tasktitle[]['title'] = $maintancetask['title'];
    $worksts[]['sts'] = $maintancetask['sts'];
}
} 

$bmTaskInfo = "SELECT 'BM ' as work_id, bcr.bm_checklist_ref_id as id, bcr.work_status as sts, bcr.checklist as title 
FROM bm_checklist_ref bcr LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id  WHERE mc.status = 0 AND bcr.work_status IN (0, 1, 2) AND (mc.role1 = '".$designation."' OR mc.role2 = '".$designation."') AND ( CURDATE() >= DATE(bcr.from_date) AND CURDATE() <= DATE(bcr.to_date) )";
$bmInfo = $connect->query($bmTaskInfo);
if($bmInfo){
while ($bmtask = $bmInfo->fetch()) { 
    $mapid[]['id'] = $bmtask['id'];
    $workid[]['work_id'] = $bmtask['work_id'];
    $tasktitle[]['title'] = $bmtask['title'];
    $worksts[]['sts'] = $bmtask['sts'];
}
}

// get campaign ref list
$campaignTaskInfo = "SELECT 'CAMPAIGN ' as work_id,cf.campaign_ref_id as id, cf.activity_involved as title,cf.work_status as sts FROM campaign_ref cf LEFT JOIN campaign c ON cf.campaign_id = c.campaign_id WHERE c.status = 0 AND cf.work_status IN (0, 1, 2) AND FIND_IN_SET('$staffid', employee_name) > 0 AND ( CURDATE() >= DATE(cf.start_date) AND CURDATE() <= DATE(cf.end_date) )";
$campaignInfo = $con->query($campaignTaskInfo);
if($campaignInfo){
while($campaigntask = $campaignInfo->fetch_assoc())
{
    $mapid[]['id'] = $campaigntask['id'];
    $workid[]['work_id'] = $campaigntask['work_id'];
    $tasktitle[]['title'] = $campaigntask['title'];
    $worksts[]['sts'] = $campaigntask['sts'];
}
}

// get assign work list and to_date > '".$today."'
$assignedTaskInfo = "SELECT 'ASSIGNED WORK ' as work_id, ref_id as id, work_status as sts, work_des_text as title FROM assign_work_ref WHERE status = 0 AND work_status IN (0, 1, 2) AND designation_id = '".$designation."' AND ( CURDATE() >= DATE(start_date) AND CURDATE() <= DATE(end_date) ) "; 
$assignInfo = $con->query($assignedTaskInfo);
if($assignInfo){
while($assignTask = $assignInfo->fetch_assoc())
{
    $mapid[]['id'] = $assignTask['id'];
    $workid[]['work_id'] = $assignTask['work_id'];
    $tasktitle[]['title'] = $assignTask['title'];
    $worksts[]['sts'] = $assignTask['sts'];
}
}

$data = array();
for ($i=0; $i<count($mapid); $i++) { 
    $sub_array   = array();
    
    $sub_array[] = $i+1;
    $sub_array[] = $workid[$i]['work_id'];
    $sub_array[] = $tasktitle[$i]['title'];

    if($worksts[$i]['sts'] == '0'){ $sts = 'Work Assigned';}
    if($worksts[$i]['sts'] == '1'){ $sts = 'In-Progress';}
    if($worksts[$i]['sts'] == '2'){ $sts = 'Pending';}
    if($worksts[$i]['sts'] == '3'){ $sts = 'Completed';}

    $sub_array[] = $sts;

    $data[]      = $sub_array;
    }

$output = array(
    'draw' => intval($_POST['draw']),
    // 'recordsTotal' => count_all_data($connect),
    // 'recordsFiltered' => $number_filter_row,
    'data' => $data
);

echo json_encode($output);

// Close the database connection
$connect = null;
?>