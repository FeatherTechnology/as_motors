<?php
//it  showing 5 days from created date.
include '../ajaxconfig.php';
@session_start();
if(isset($_SESSION['role'])){
    $role = $_SESSION['role'];
}
if(isset($_SESSION['staffid'])){
    $staffid = $_SESSION['staffid'];
}
if(isset($_SESSION['designation_id'])){
    $designation_id = $_SESSION['designation_id'];
}
if(isset($_SESSION['curdateFromIndexPage'])){
    $curdate = $_SESSION['curdateFromIndexPage'];
}
if($role != 1){
?>

<table class="table custom-table">
    <!-- <thead>
    <tr>
        <th>S.No</th>
        <th>Task Name</th>
        <th>Work Description</th>
    </tr>
    </thead>
    <tbody> -->

<?php

//Pending Task Start //
$pending_task_details = $mysqli->query("SELECT * FROM `pending_task_notification` WHERE (`staff_id` = '$staffid' || `designation_id` = '$designation_id') &&  '$curdate' <= created_date + INTERVAL 4 DAY ORDER BY created_date DESC");
$sno = 1;
$hideShow = '1';
while($row = $pending_task_details->fetch_object()) {
$taskName = $row->task_name;

    if($taskName == 'ToDo'){ 
        $TodoTaskInfo = $connect->query("SELECT 'ToDo' as tb, work_status as sts FROM todo_creation WHERE work_status != 3 AND status = 0 AND todo_id = '$row->task_id' ");
        
        if($TodoTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }

    }else if($taskName == 'KRA&KPI '){
        $krakpitask = $connect->query("SELECT 'KRA&KPI ' as tb, kcm.work_status as sts 
        FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
        JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id WHERE kc.status = 0 AND kcm.work_status IN (0, 1, 2) AND kcm.krakpi_calendar_map_id = '$row->task_id' ");

        if($krakpitask -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'AUDIT AREA '){
        $auditTaskInfo = $connect->query("SELECT 'AUDIT AREA ' as tb, acr.work_status as sts
        FROM audit_area_creation_ref acr LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id WHERE ac.status = 0 AND acr.work_status IN (0, 1, 2) AND acr.audit_area_creation_ref_id = '$row->task_id' ");

        if($auditTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }

    }else if($taskName == 'PM MAINTENANCE '){
        $maintanceTaskInfo = $connect->query("SELECT 'PM MAINTENANCE ' as tb, pcr.work_status as sts
        FROM pm_checklist_ref pcr LEFT JOIN maintenance_checklist mc
        ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id WHERE mc.status = 0 AND pcr.work_status IN (0, 1, 2) AND pcr.pm_checklist_ref_id = '$row->task_id' ");

        if($maintanceTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'CAMPAIGN'){
        $campgnTaskInfo = $connect->query("SELECT 'CAMPAIGN' as tb, work_status as sts FROM campaign_ref WHERE work_status != 3 AND campaign_ref_id = '$row->task_id' ");

        if($campgnTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'INSURANCE REGISTER'){
        $insregrefTaskInfo = $connect->query("SELECT 'INSURANCE REGISTER' as tb, ins.work_status as sts FROM `insurance_register_ref` ins LEFT JOIN insurance_creation ic ON ins.insurance_id = ic.insurance_id WHERE  ins.work_status != 3 AND ins.ins_reg_ref_id = '$row->task_id' ");

        if($insregrefTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'BM MAINTENANCE'){
        $bmTaskInfo = $connect->query("SELECT 'BM MAINTENANCE' as tb, bcr.work_status as sts
        FROM bm_checklist_ref bcr LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id  WHERE mc.status = 0 AND bcr.work_status IN (0, 1, 2) AND bcr.bm_checklist_ref_id = '$row->task_id' ");

        if($bmTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'FC INSURANCE RENEW'){
        $fcinsTaskInfo = $connect->query("SELECT 'FC INSURANCE RENEW' as tb, work_status as sts FROM `fc_insurance_renew` WHERE work_status != 3 AND fc_insurance_renew_id = '$row->task_id' ");

        if($fcinsTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else if($taskName == 'ASSIGN WORK'){
        $assignworkTaskInfo = $connect->query("SELECT 'ASSIGN WORK' as tb, work_status as sts FROM assign_work_ref WHERE work_status != 3 AND status = 0 AND ref_id = '$row->task_id' ");

        if($assignworkTaskInfo -> rowCount() >0){
            $hideShow = '0'; //True.

        }else{
            $hideShow = '1'; //False.
            
        }
        
    }else{
        $hideShow = '1'; //False.

    }

if($hideShow == '0'){
?>
    <tr>
        <td><?php echo $sno++; ?></td>
        <td><?php echo $row->task_name; ?></td>
        <td><?php echo $row->work_des; ?></td>
        <td>Need to Complete Task</td>
    </tr>

<?php }//hideshow if 
}//while if?>    
<input type="hidden" id="rowcnt" value="<?php echo $sno;?>">
<!-- </tbody> -->
</table>

<?php  }else{ ?>
    <input type="hidden" id="rowcnt" value="1">
    
<?php }//if role find. ?>
