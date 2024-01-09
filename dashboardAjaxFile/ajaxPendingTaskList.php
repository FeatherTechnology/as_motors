<?php
include('../ajaxconfig.php');
@session_start();

if(isset($_SESSION["curdateFromIndexPage"])){
    $curdate = $_SESSION["curdateFromIndexPage"];
}
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 
$column = array(
    
    'tb',
    'title',
    'end_date'
);
$taskid = array();
$workid = array();
$wrksts = array();
$tasktitle = array();
$designation = array();
$endate = array();

$TodoTaskInfo ="SELECT 'ToDo' as tb, work_des as title, to_date as end_date, assign_to as assign, work_status as sts, todo_id FROM todo_creation WHERE work_status != 3 AND status = 0 AND
(
    `to_date` >= '$curdate'
    AND
    `to_date` <= '$curdate' + INTERVAL 10 DAY
)";
$todoInfo = $connect->query($TodoTaskInfo);
if($todoInfo){                
    while ($todotask = $todoInfo->fetch()) { 
        $taskid[]['taskid'] = $todotask['todo_id'];
        $wrksts[]['sts'] = $todotask['sts'];
        $workid[]['tb'] = $todotask['tb'];
        $tasktitle[]['title'] = $todotask['title'];
        $designation[]['designation'] = $todotask['assign'];
        $endate[]['endate'] = $todotask['end_date'];
    }  
    // Close the previous result set 
    $todoInfo->closeCursor(); 
} 

$rr = array();
$kpi = array();
$checkqry = $con->query("SELECT kcr.rr, kcr.kpi FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm. krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0 AND kcm.work_status IN (0, 1, 2)");
while($row = $checkqry->fetch_assoc()){
    $rr[] = $row["rr"];
    $kpi[] = $row["kpi"];
}

$qry = "";

foreach($rr as $val){
    if($val == 'New'){
        
        $qry .= "SELECT 'KRA&KPI ' as tb, kcm.work_status as sts, kcr.kpi as title, kcm.to_date as end_date, kc.designation  as assign, kcm.krakpi_calendar_map_id
                FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0 AND kcm.work_status IN (0, 1, 2)  AND (kcm.to_date >= '$curdate' AND kcm.to_date <= '$curdate' + INTERVAL 10 DAY );";
    }else{
        $qry .= "SELECT 'KRA&KPI ' as tb, kcm.work_status as sts, rrr.rr as title, kcm.to_date as end_date, kc.designation  as assign, kcm.krakpi_calendar_map_id 
                FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
                JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id WHERE kc.status = 0 AND kcm.work_status IN (0, 1, 2) AND (kcm.to_date >= '$curdate' AND kcm.to_date <= '$curdate' + INTERVAL 10 DAY );";
    }
}
if($qry){
$krakpiInfo = $connect->query($qry);
if($krakpiInfo){
while ($krakpitask = $krakpiInfo->fetch()) { 
    $taskid[]['taskid'] = $krakpitask['krakpi_calendar_map_id'];
    $wrksts[]['sts'] = $krakpitask['sts'];
    $workid[]['tb'] = $krakpitask['tb'];
    $tasktitle[]['title'] = $krakpitask['title'];
    $designation[]['designation'] = $krakpitask['assign'];
    $endate[]['endate'] = $krakpitask['end_date'];
    }
}
// Close the previous result set 
$krakpiInfo->closeCursor();
}

$auditTaskInfo ="SELECT 'AUDIT AREA ' as tb, acr.work_status as sts, ac.audit_area as title, acr.to_date as end_date, ac.role1 as assign, acr.audit_area_creation_ref_id
FROM audit_area_creation_ref acr LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id WHERE ac.status = 0 AND acr.work_status IN (0, 1, 2) AND (acr.to_date >= '$curdate' AND acr.to_date <= '$curdate' + INTERVAL 10 DAY )";
$auditInfo = $connect->query($auditTaskInfo);
if($auditInfo){                
    while ($audittask = $auditInfo->fetch()) { 
        $taskid[]['taskid'] = $audittask['audit_area_creation_ref_id'];
        $wrksts[]['sts'] = $audittask['sts'];
        $workid[]['tb'] = $audittask['tb'];
        $tasktitle[]['title'] = $audittask['title'];
        $designation[]['designation'] = $audittask['assign'];
        $endate[]['endate'] = $audittask['end_date'];
    }  
    // Close the previous result set 
    $auditInfo->closeCursor(); 
} 

$maintanceTaskInfo = "SELECT 'PM MAINTENANCE '  as tb, pcr.work_status as sts, pcr.checklist as title, pcr.to_date as end_date, pcr.role1 as assign, pcr.pm_checklist_ref_id
FROM pm_checklist_ref pcr LEFT JOIN maintenance_checklist mc
ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id WHERE mc.status = 0 AND pcr.work_status IN (0, 1, 2) AND (pcr.to_date >= '$curdate' AND pcr.to_date <= '$curdate' + INTERVAL 10 DAY )";
$maintanceInfo = $connect->query($maintanceTaskInfo);
if($maintanceInfo){
while ($maintancetask = $maintanceInfo->fetch()) { 
    $taskid[]['taskid'] = $maintancetask['pm_checklist_ref_id'];
    $wrksts[]['sts'] = $maintancetask['sts'];
    $workid[]['tb'] = $maintancetask['tb'];
    $tasktitle[]['title'] = $maintancetask['title'];
    $designation[]['designation'] = $maintancetask['assign'];
    $endate[]['endate'] = $maintancetask['end_date'];
}

// Close the previous result set 
$maintanceInfo->closeCursor();
}

$campgnTaskInfo = "SELECT 'CAMPAIGN' as tb, activity_involved as title, end_date as end_date, employee_name as assign, work_status as sts, campaign_ref_id FROM campaign_ref WHERE work_status != 3 AND ( `end_date` >= '$curdate' AND `end_date` <= '$curdate' + INTERVAL 10 DAY ) ";
$cmpgnInfo = $connect->query($campgnTaskInfo);
if($cmpgnInfo){
while ($cmpgntask = $cmpgnInfo->fetch()) { 
    $taskid[]['taskid'] = $cmpgntask['campaign_ref_id'];
    $wrksts[]['sts'] = $cmpgntask['sts'];
    $workid[]['tb'] = $cmpgntask['tb'];
    $tasktitle[]['title'] = $cmpgntask['title'];
    $designation[]['designation'] = $cmpgntask['assign'];
    $endate[]['endate'] = $cmpgntask['end_date'];
}

// Close the previous result set 
$cmpgnInfo->closeCursor();

} 

$insregrefTaskInfo = "SELECT 'INSURANCE REGISTER' as tb, ic.insurance_name as title, ins.work_status as sts, ins.to_date as end_date, ins.designation_id as assign, ins.ins_reg_ref_id FROM `insurance_register_ref` ins LEFT JOIN insurance_creation ic ON ins.insurance_id = ic.insurance_id WHERE  ins.work_status != 3 AND (ins.to_date >= '$curdate' AND ins.to_date <= '$curdate' + INTERVAL 10 DAY ) ";
$insregrefInfo = $connect->query($insregrefTaskInfo);
if($insregrefInfo){
while ($insregreftask = $insregrefInfo->fetch()) { 
    $taskid[]['taskid'] = $insregreftask['ins_reg_ref_id'];
    $wrksts[]['sts'] = $insregreftask['sts'];
    $workid[]['tb'] = $insregreftask['tb'];
    $tasktitle[]['title'] = $insregreftask['title'];
    $designation[]['designation'] = $insregreftask['assign'];
    $endate[]['endate'] = $insregreftask['end_date'];
}

// Close the previous result set 
$insregrefInfo->closeCursor();

}           
            
$bmTaskInfo = "SELECT 'BM MAINTENANCE' as tb, bcr.work_status as sts, bcr.checklist as title, bcr.to_date as end_date, bcr.role1 as assign, bcr.bm_checklist_ref_id 
FROM bm_checklist_ref bcr LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id  WHERE mc.status = 0 AND bcr.work_status IN (0, 1, 2) AND (bcr.to_date >= '$curdate' AND bcr.to_date <= '$curdate' + INTERVAL 10 DAY ) ";
$bmInfo = $connect->query($bmTaskInfo);
if($bmInfo){
while ($bmtask = $bmInfo->fetch()) { 
    $taskid[]['taskid'] = $bmtask['bm_checklist_ref_id'];
    $wrksts[]['sts'] = $bmtask['sts'];
    $workid[]['tb'] = $bmtask['tb'];
    $tasktitle[]['title'] = $bmtask['title'];
    $designation[]['designation'] = $bmtask['assign'];
    $endate[]['endate'] = $bmtask['end_date'];
}

// Close the previous result set 
$bmInfo->closeCursor();
}    

$fcinsTaskInfo = "SELECT 'FC INSURANCE RENEW' as tb, assign_remark as title, work_status as sts, to_date as end_date, assign_staff_name as assign, fc_insurance_renew_id FROM `fc_insurance_renew` WHERE work_status != 3 AND
(`to_date` >= '$curdate' AND `to_date` <= '$curdate' + INTERVAL 10 DAY )";
$fcinsInfo = $connect->query($fcinsTaskInfo);
if($fcinsInfo){
while ($fcinstask = $fcinsInfo->fetch()) { 
    $taskid[]['taskid'] = $fcinstask['fc_insurance_renew_id'];
    $wrksts[]['sts'] = $fcinstask['sts'];
    $workid[]['tb'] = $fcinstask['tb'];
    $tasktitle[]['title'] = $fcinstask['title'];
    $designation[]['designation'] = $fcinstask['assign'];
    $endate[]['endate'] = $fcinstask['end_date'];
}

// Close the previous result set 
$fcinsInfo->closeCursor();
}    

$assignworkTaskInfo = "SELECT 'ASSIGN WORK' as tb, work_des_text as title, to_date as end_date, designation_id as assign, work_status as sts, ref_id FROM assign_work_ref WHERE work_status != 3 AND status = 0 AND
( `to_date` >= '$curdate' AND `to_date` <= '$curdate' + INTERVAL 10 DAY) ";
$assignworkInfo = $connect->query($assignworkTaskInfo);
if($assignworkInfo){
while ($assignworktask = $assignworkInfo->fetch()) { 
    $taskid[]['taskid'] = $assignworktask['ref_id'];
    $wrksts[]['sts'] = $assignworktask['sts'];
    $workid[]['tb'] = $assignworktask['tb'];
    $tasktitle[]['title'] = $assignworktask['title'];
    $designation[]['designation'] = $assignworktask['assign'];
    $endate[]['endate'] = $assignworktask['end_date'];
}

// Close the previous result set 
$assignworkInfo->closeCursor();
} 

$data = array();

$sno = 1;
// foreach ($result as $row) {
    for ($i=0; $i<count($wrksts); $i++) {
    $sub_array   = array();

    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $sub_array[] = $workid[$i]['tb'];
    $sub_array[] = $tasktitle[$i]['title'];
    $sub_array[] = date('d-m-Y',strtotime($endate[$i]['endate']));

    if ($wrksts[$i]['sts'] == 0) {$work_status = 'Work Assigned';}
    if ($wrksts[$i]['sts'] == 1) {$work_status = 'In Progress';}
    if ($wrksts[$i]['sts'] == 2) {$work_status = 'Pending';}
    if ($wrksts[$i]['sts'] == 3) {$work_status = 'Completed';}
    $sub_array[] = $work_status;

    $desgn_id = $designation[$i]['designation'];
    $assign = '';
    if($workid[$i]['tb'] == 'ToDo' || $workid[$i]['tb'] == 'Campaign' || $workid[$i]['tb'] == 'FC INSURANCE RENEW'){
        $getStaff = $mysqli->query("SELECT staff_name FROM staff_creation where FIND_IN_SET(staff_id, '".$desgn_id."') ");
        while($staffList = $getStaff->fetch_assoc()){
            $assign .= $staffList['staff_name'].', ';
        }
    }else{ //we using 9 database table to get record and show in one html table, in project we assign task against designation but todo_creation, campaign_ref, FC INSURANCE RENEW are against staff so splited by condition and based on it show designation and staff name.
        $getDesignation = $mysqli->query("SELECT designation_name FROM designation_creation where designation_id = '".$desgn_id."' ");
        $designationList = $getDesignation->fetch_assoc();
        $assign = $designationList['designation_name'];
    }

    $sub_array[] = $assign;
    // $sub_array[] = "<input type='button' class='btn btn-primary' id='sendNotifications' value='Send Notification' onclick='sendNotification('".$workid[$i]['tb']."','".$workid[$i]['tb']."','".$tasktitle[$i]['title']."')'>";
    $sub_array[] = "<input type='button' class='btn btn-primary' id='sendNotifications' value='Send Notification' onclick=\"sendNotification('".$workid[$i]['tb']."','".$taskid[$i]['taskid']."','".$tasktitle[$i]['title']."', '".$designation[$i]['designation']."')\">";


    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT 'assign_work_ref' as tb, work_des_text as title, to_date as end_date, designation_id as assign FROM assign_work_ref 
    UNION 
    SELECT 'todo' as tb, work_des as title, to_date as end_date, assign_to as assign FROM todo_creation
    UNION
    SELECT 'camp' as tb, activity_involved as title, end_date as end_date, employee_name as assign FROM campaign_ref";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
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