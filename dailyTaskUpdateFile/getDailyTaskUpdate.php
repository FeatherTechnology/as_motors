<?php
//Assign work ////No Frequency
//todo  ////No Frequency
// krakpi_ref
// audit_area 
// pm_checklist_ref
// BM
// campaign ////No Frequency
// insurance ////No Frequency - Daily Task
// FC_INS_renew ////No Frequency

include '../ajaxconfig.php';

if(isset($_POST['desgn_id'])){
    $designation = $_POST['desgn_id'];
}
?>

<table class="table custom-table " id="dailytaskTable">
    <thead>
    <tr>
        <th>Task</th>
        <th>Status</th>
        <th>Remark</th>
        <th>File Upload</th>
    </tr>
    </thead>
    <tbody>
        <?php

$rr = array();$kpi = array();
$checkqry = $con->query("SELECT kcr.rr, kcr.kpi FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm. krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0 AND kcr.frequency = 'Daily Task' AND kc.designation = '".$designation."' AND kcm.work_status IN (0, 1, 2);");
while($row = $checkqry->fetch_assoc()){
    $rr[] = $row["rr"];
    $kpi[] = $row["kpi"];
}

$qry = "";

foreach($rr as $val){
    if($val == 'New'){
        
        $qry .= "SELECT 'krakpi_ref ' as work_id, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts, kcr.kpi as title 
                FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0 AND kcr.frequency = 'Daily Task' AND kc.designation = '".$designation."' AND kcm.work_status IN (0, 1, 2)
                UNION ALL";
    }else{
        $qry .= "SELECT 'krakpi_ref ' as work_id, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts, rrr.rr as title 
                FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
                JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id WHERE kc.status = 0 AND kcr.frequency = 'Daily Task' AND kc.designation = '".$designation."' AND kcm.work_status IN (0, 1, 2)
                UNION ALL";
    }
}
            
            $qry .="
            SELECT 'audit_area ' as work_id, acr.audit_area_creation_ref_id as id, acr.work_status as sts, ac.audit_area  as title
            FROM audit_area_creation_ref acr LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id WHERE ac.status = 0 AND ac.frequency = 'Daily Task' AND acr.work_status IN (0, 1, 2) AND (ac.role1 = '".$designation."' OR ac.role2 = '".$designation."') 

            UNION ALL

            SELECT 'maintenance '  as work_id, pcr.pm_checklist_ref_id as id, pcr.work_status as sts, pcr.checklist as title
            FROM pm_checklist_ref pcr LEFT JOIN maintenance_checklist mc
            ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id WHERE mc.status = 0 AND pc.frequency = 'Daily Task' AND pcr.work_status IN (0, 1, 2) AND (mc.role1 = '".$designation."' OR mc.role2 = '".$designation."')

            UNION ALL

            SELECT 'BM ' as work_id, bcr.bm_checklist_ref_id as id, bcr.work_status as sts, bcr.checklist as title 
            FROM bm_checklist_ref bcr LEFT JOIN maintenance_checklist mc 
            ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id  WHERE mc.status = 0 AND bc.frequency = 'Daily Task' AND bcr.work_status IN (0, 1, 2) AND (mc.role1 = '".$designation."' OR mc.role2 = '".$designation."') 
            ";

            $taskInfo = $connect->query($qry);
            
        ?>
            <tr>
                <td> 
                    <select class="form-control" name="daily_task" id="daily_task">
                        <option value=''>Select Task</option>
                        <?php while ($task = $taskInfo->fetch()) { ?>
                            <option value='<?php echo $task['id'];?>' data-value="<?php echo $task['work_id'];?>"><?php echo $task['title'];?></option>

                        <?php } ?>
                    </select> 
                </td>
                <td> 
                    <select class="form-control" name="work_status" id="work_status">
                        <option value=''>Select Status</option>
                        <option value='1'>In Progress</option>
                        <option value='2'>Pending</option>
                        <option value='3'>Completed</option>
                    </select> 
                </td>
                <td> <input type="text" class="form-control" name="work_remark" id="work_remark" > </td>
                <td> <input type="file" class="form-control" name="status_file" id="status_file" > </td>
            </tr>
    </tbody>
</table>
