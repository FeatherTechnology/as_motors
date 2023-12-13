<?php
include '../ajaxconfig.php';
//krakpi.\\         ////department based.
//audit.\\          ////department based.
//maintance.\\      ////Branch based.
//bm.\\             ////Branch based.
//Campaign.\\       ////staff based.
//Assign Work\\     ////department based.
//todo.\\           ////staff based.
// insurance register.\\  ////department based.
//fc_insurance_renew.\\  ////staff based.
?>

<table class="table custom-table" id="staff_report_data">
    <thead>
        <tr>
            <th width="50">S.No</th>
            <th>Staff Code</th>
            <th>Staff Name</th>
            <th>Work Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Current Status</th>
            <th>Completed File</th>
        </tr>
    </thead>
    <tbody>

<?php
if(isset($_POST["task_name"])){
    $task_name = ($_POST["task_name"]);
}

$workid = array();
$mapid = array();
$tasktitle = array();
$worksts = array();
$fromdt = array();
$todt = array();
$completedFile = array();
$staffCode = array();
$staffName = array();

if($task_name == '1'){//KRAKPI 
//KRAKPI start//
// $rr = array();
// $kpi = array();
// //here finding the kpi is from rr OR from new, if rr means it has to get data from rr_creation_ref table else get data in krakpi_creation_ref. so first checking the whether it is new or kpi(rr) then based on data next query will run.
// $checkqry = $con->query("SELECT kcr.rr, kcr.kpi FROM krakpi_calendar_map kcm LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id LEFT JOIN krakpi_creation_ref kcr ON kcm. krakpi_ref_id = kcr.krakpi_ref_id WHERE kc.status = 0  AND kc.department = '".$dept_name."' AND ( '".$dept_from_date."' >= DATE(kcm.from_date) OR DATE(kcm.to_date) <= '".$dept_to_date."' )");
// while($row = $checkqry->fetch_assoc()){
//     $rr[] = $row["rr"];
//     $kpi[] = $row["kpi"];
// }

$qry = "";

$qry = "SELECT 'KRA & KPI' as work_id, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts,DATE(kcm.from_date) as f_date, DATE(kcm.to_date) as t_date, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as title, sc.staff_name,sc.emp_code 
FROM krakpi_calendar_map kcm 
LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id 
LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id 
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
WHERE kc.status = 0 && sc.status = 0 ";

$krakpiInfo = $connect->query($qry);
if($krakpiInfo){
    
while ($krakpitask = $krakpiInfo->fetch()) { 

    $krakpi_id = 'krakpi_ref '.$krakpitask['id'];
    $krakpimapdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$krakpi_id."' ");
    if(mysqli_num_rows($krakpimapdetails)>0){ //checks if the row > 0 then show completed_file else empty.
    $krakpimap = $krakpimapdetails->fetch_assoc();  
        $krakpi_completed_file = $krakpimap["completed_file"];
    }else{
        $krakpi_completed_file = '';
    }

    $mapid[]['id'] = $krakpitask['id'];
    $workid[]['work_id'] = $krakpitask['work_id'];
    $tasktitle[]['title'] = $krakpitask['title'];
    $worksts[]['sts'] = $krakpitask['sts'];
    $fromdt[]['f_date'] = $krakpitask['f_date'];
    $todt[]['t_date'] = $krakpitask['t_date'];
    $completedFile[]['com_file'] = $krakpi_completed_file;
    $staffCode[]['emp_code'] = $krakpitask['emp_code'];
    $staffName[]['staff_name'] = $krakpitask['staff_name'];
    }
}
//KRAKPI END//

}else if($task_name == '2'){ //audit

//Audit start//
$auditTaskInfo ="SELECT 'AUDIT ' as work_id, acr.audit_area_creation_ref_id as id, acr.work_status as sts, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, sc.staff_name, sc.emp_code
FROM audit_area_creation_ref acr 
LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
LEFT JOIN staff_creation sc ON ac.role1 = sc.designation
WHERE ac.status = 0 && sc.status = 0 

UNION

SELECT 'AUDIT ' as work_id, acr.audit_area_creation_ref_id as id, acr.work_status as sts, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, sc.staff_name, sc.emp_code
FROM audit_area_creation_ref acr 
LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
LEFT JOIN staff_creation sc ON ac.role2 = sc.designation
WHERE ac.status = 0 && sc.status = 0  ";

$auditInfo = $connect->query($auditTaskInfo);
if($auditInfo){
while ($audittask = $auditInfo->fetch()) { 

    $audit_id = 'audit_area '.$audittask['id'];
    $auditrefdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$audit_id."' ");
    if(mysqli_num_rows($auditrefdetails)>0){
    $auditref = $auditrefdetails->fetch_assoc();
        $audit_completed_file = $auditref["completed_file"];
    }else{
        $audit_completed_file = '';
    }

    $mapid[]['id'] = $audittask['id'];
    $workid[]['work_id'] = $audittask['work_id'];
    $tasktitle[]['title'] = $audittask['title'];
    $worksts[]['sts'] = $audittask['sts'];
    $fromdt[]['f_date'] = $audittask['f_date'];
    $todt[]['t_date'] = $audittask['t_date'];
    $completedFile[]['com_file'] = $audit_completed_file;
    $staffCode[]['emp_code'] = $audittask['emp_code'];
    $staffName[]['staff_name'] = $audittask['staff_name'];
}   
} 
//Audit END//

}else if($task_name == '3'){ //pm maintance
//Maintance start//          
$maintanceTaskInfo = "SELECT 'MAINTENANCE ' as work_id, pcr.pm_checklist_ref_id as id, pcr.work_status as sts, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date, sc.staff_name, sc.emp_code 
FROM pm_checklist_ref pcr 
LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id 
LEFT JOIN staff_creation sc ON mc.role1 = sc.designation
WHERE mc.status = 0 && sc.status = 0 

UNION

SELECT 'MAINTENANCE ' as work_id, pcr.pm_checklist_ref_id as id, pcr.work_status as sts, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date,sc.staff_name, sc.emp_code 
FROM pm_checklist_ref pcr 
LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id 
LEFT JOIN staff_creation sc ON mc.role2 = sc.designation
WHERE mc.status = 0 && sc.status = 0  ";

$maintanceInfo = $connect->query($maintanceTaskInfo);
if($maintanceInfo){
while ($maintancetask = $maintanceInfo->fetch()) { 

    $maintance_id = 'maintenance '.$maintancetask['id'];
    $maintancedetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$maintance_id."' ");
    if(mysqli_num_rows($maintancedetails)>0){
    $maintancemap = $maintancedetails->fetch_assoc();    
        $maintance_completed_file = $maintancemap["completed_file"];
    }else{
        $maintance_completed_file = '';
    }

    $mapid[]['id'] = $maintancetask['id'];
    $workid[]['work_id'] = $maintancetask['work_id'];
    $tasktitle[]['title'] = $maintancetask['title'];
    $worksts[]['sts'] = $maintancetask['sts'];
    $fromdt[]['f_date'] = $maintancetask['f_date'];
    $todt[]['t_date'] = $maintancetask['t_date'];
    $completedFile[]['com_file'] = $maintance_completed_file;
    $staffCode[]['emp_code'] = $maintancetask['emp_code'];
    $staffName[]['staff_name'] = $maintancetask['staff_name'];
}
} 
//Maintance END//

}else if($task_name == '4'){ //bm maintance
//BM Start//
$bmTaskInfo = "SELECT 'BM ' as work_id, bcr.bm_checklist_ref_id as id, bcr.work_status as sts, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date,sc.staff_name, sc.emp_code
FROM bm_checklist_ref bcr 
LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id 
LEFT JOIN staff_creation sc ON mc.role1 = sc.designation
WHERE mc.status = 0 && sc.status = 0 

UNION

SELECT 'BM ' as work_id, bcr.bm_checklist_ref_id as id, bcr.work_status as sts, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date, sc.staff_name, sc.emp_code
FROM bm_checklist_ref bcr 
LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id 
LEFT JOIN staff_creation sc ON mc.role2 = sc.designation
WHERE mc.status = 0 && sc.status = 0 ";

$bmInfo = $connect->query($bmTaskInfo);
if($bmInfo){
while ($bmtask = $bmInfo->fetch()) { 

    $bm_id = 'maintenance '.$bmtask['id'];
    $bmdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$bm_id."' ");
    if(mysqli_num_rows($bmdetails)>0){
        $bmref = $bmdetails->fetch_assoc(); 
        $bm_completed_file = $bmref["completed_file"];
    }else{
        $bm_completed_file = '';
    }

    $mapid[]['id'] = $bmtask['id'];
    $workid[]['work_id'] = $bmtask['work_id'];
    $tasktitle[]['title'] = $bmtask['title'];
    $worksts[]['sts'] = $bmtask['sts'];
    $fromdt[]['f_date'] = $bmtask['f_date'];
    $todt[]['t_date'] = $bmtask['t_date'];
    $completedFile[]['com_file'] = $bm_completed_file;
    $staffCode[]['emp_code'] = $bmtask['emp_code'];
    $staffName[]['staff_name'] = $bmtask['staff_name'];
}
}
//BM END//

}else if($task_name == '5'){ //campaign

//campaign Start//
$campaignTaskInfo = "SELECT 'CAMPAIGN ' as work_id,cf.campaign_ref_id as id, cf.activity_involved as title,cf.work_status as sts, DATE(cf.start_date) as f_date, DATE(cf.end_date) as t_date, sc.staff_name, sc.emp_code
FROM campaign_ref cf 
LEFT JOIN campaign c ON cf.campaign_id = c.campaign_id 
LEFT JOIN staff_creation sc ON cf.employee_name = sc.staff_id
WHERE c.status = 0 && sc.status = 0 ";

$campaignInfo = $con->query($campaignTaskInfo);
if($campaignInfo){
while($campaigntask = $campaignInfo->fetch_assoc())
{
    $campaign_id = 'campaign '.$campaigntask['id'];
    $campaigndetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$campaign_id."' ");
    if(mysqli_num_rows($campaigndetails)>0){
    $campaigninfo = $campaigndetails->fetch_assoc();
        $campaign_completed_file = $campaigninfo["completed_file"];
    }else{
        $campaign_completed_file = '';
    }

    $mapid[]['id'] = $campaigntask['id'];
    $workid[]['work_id'] = $campaigntask['work_id'];
    $tasktitle[]['title'] = $campaigntask['title'];
    $worksts[]['sts'] = $campaigntask['sts'];
    $fromdt[]['f_date'] = $campaigntask['f_date'];
    $todt[]['t_date'] = $campaigntask['t_date'];
    $completedFile[]['com_file'] = $campaign_completed_file;
    $staffCode[]['emp_code'] = $campaigntask['emp_code'];
    $staffName[]['staff_name'] = $campaigntask['staff_name'];
}
}
//campaign END//

}else if($task_name == '6'){ //assign work

//assign work list Start//
$assignedTaskInfo = "SELECT 'ASSIGNED WORK ' as work_id, awf.ref_id as id, awf.work_status as sts, awf.work_des_text as title, DATE(awf.from_date) as f_date, DATE(awf.to_date) as t_date,sc.staff_name, sc.emp_code
FROM assign_work_ref awf
LEFT JOIN staff_creation sc ON awf.designation_id = sc.designation
WHERE awf.status = 0 && sc.status = 0 "; 

$assignInfo = $con->query($assignedTaskInfo);
if($assignInfo){
while($assignTask = $assignInfo->fetch_assoc())
{ 
    $assign_id = 'assign_work '.$assignTask['id'];
    $assigndetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$assign_id."' ");
    if(mysqli_num_rows($assigndetails)>0){
    $assigninfo = $assigndetails->fetch_assoc();
        $assign_completed_file = $assigninfo["completed_file"];
    }else{
        $assign_completed_file = '';
    }

    $mapid[]['id'] = $assignTask['id'];
    $workid[]['work_id'] = $assignTask['work_id'];
    $tasktitle[]['title'] = $assignTask['title'];
    $worksts[]['sts'] = $assignTask['sts'];
    $fromdt[]['f_date'] = $assignTask['f_date'];
    $todt[]['t_date'] = $assignTask['t_date'];
    $completedFile[]['com_file'] = $assign_completed_file;
    $staffCode[]['emp_code'] = $assignTask['emp_code'];
    $staffName[]['staff_name'] = $assignTask['staff_name'];
}
}
//assign work list END//

}else if($task_name == '7'){ //todo

//Todo Start //
$todoqry = "SELECT 'TODO ' as work_id, tc.todo_id as id, tc.work_status as sts, tc.work_des as title, DATE(tc.from_date) as f_date, DATE(tc.to_date) as t_date, sc.staff_name, sc.emp_code
FROM todo_creation tc 
LEFT JOIN staff_creation sc ON FIND_IN_SET(sc.staff_id, tc.assign_to)
WHERE tc.status = 0 && sc.status = 0 ";

$gettodoinfo = $con->query($todoqry);
if($gettodoinfo){
while($todoinfo = $gettodoinfo->fetch_assoc())
{
    $todo_id = 'todo '.$todoinfo['id'];
    $tododetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$todo_id."' ");
    if(mysqli_num_rows($tododetails)>0){
    $todoinf = $tododetails->fetch_assoc();   
        $todo_completed_file = $todoinf["completed_file"];
    }else{
        $todo_completed_file = '';
    }

    $mapid[]['id'] = $todoinfo['id'];
    $workid[]['work_id'] = $todoinfo['work_id'];
    $tasktitle[]['title'] = $todoinfo['title'];
    $worksts[]['sts'] = $todoinfo['sts'];
    $fromdt[]['f_date'] = $todoinfo['f_date'];
    $todt[]['t_date'] = $todoinfo['t_date'];
    $completedFile[]['com_file'] = $todo_completed_file;
    $staffCode[]['emp_code'] = $todoinfo['emp_code'];
    $staffName[]['staff_name'] = $todoinfo['staff_name'];
}
}
//ToDo END //

}else if($task_name == '8'){ //insurance

//Insurance Register Start //
$insqry = "SELECT 'INSURANCE REGISTER ' as work_id, irr.ins_reg_ref_id as id, irr.work_status as sts, DATE(irr.from_date) as f_date, DATE(irr.to_date) as t_date,ir.insurance_id as ins_id,sc.staff_name, sc.emp_code 
FROM insurance_register_ref irr 
LEFT JOIN insurance_register ir ON irr.ins_reg_id = ir.ins_reg_id 
LEFT JOIN staff_creation sc ON ir.designation_id = sc.designation
WHERE ir.status = 0 && sc.status = 0 ";  

$insdeatils = $con->query($insqry);
if($insdeatils){
while($insInfo = $insdeatils->fetch_assoc())
{
    $inscreation = $con->query("SELECT insurance_name FROM insurance_creation WHERE status = 0 AND insurance_id = '". $insInfo["ins_id"]."' ");
    $inscrtion = $inscreation->fetch_assoc();
        $insurance_name = $inscrtion["insurance_name"];

    $insurance_id = 'insurance '.$insInfo['id'];
    $insurancedetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$insurance_id."' ");
    if(mysqli_num_rows($insurancedetails)>0){
        $insurancemap = $insurancedetails->fetch_assoc();    
        $insurance_completed_file = $insurancemap["completed_file"];
    }else{
        $insurance_completed_file = '';
    }

    $mapid[]['id'] = $insInfo['id'];
    $workid[]['work_id'] = $insInfo['work_id'];
    $tasktitle[]['title'] = $insurance_name;
    $worksts[]['sts'] = $insInfo['sts'];
    $fromdt[]['f_date'] = $insInfo['f_date'];
    $todt[]['t_date'] = $insInfo['t_date'];
    $completedFile[]['com_file'] = $insurance_completed_file;
    $staffCode[]['emp_code'] = $insInfo['emp_code'];
    $staffName[]['staff_name'] = $insInfo['staff_name'];
}
}
//Insurance Register END //

}else if($task_name == '9'){ //fc ins 
//FC Ins Start //
$fc_ins_details = $con->query("SELECT 'FC INSURANCE RENEWAL ' as work_id, fir.fc_insurance_renew_id as id, fir.work_status as sts, fir.assign_remark as title, DATE(fir.from_date) as f_date, DATE(fir.to_date) as t_date,sc.staff_name, sc.emp_code 
FROM fc_insurance_renew fir
LEFT JOIN staff_creation sc ON fir.assign_staff_name = sc.staff_id
WHERE fir.status = 0 && sc.status = 0 ");
if(mysqli_num_rows($fc_ins_details)>0){
while($fcInfo = $fc_ins_details->fetch_assoc())
{
    $fc_ins_renew_id = 'FC_INS_renew '.$fcInfo['id'];
    $fcinsdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$fc_ins_renew_id."' ");
    if(mysqli_num_rows($fcinsdetails)>0){ 
    $fcinsmap = $fcinsdetails->fetch_assoc();
            $fcins_completed_file = $fcinsmap["completed_file"];
        }else{
            $fcins_completed_file = '';
        }

    $mapid[]['id'] = $fcInfo['id'];
    $workid[]['work_id'] = $fcInfo['work_id'];
    $tasktitle[]['title'] = $fcInfo['title'];
    $worksts[]['sts'] = $fcInfo['sts'];
    $fromdt[]['f_date'] = $fcInfo['f_date'];
    $todt[]['t_date'] = $fcInfo['t_date'];
    $completedFile[]['com_file'] = $fcins_completed_file;
    $staffCode[]['emp_code'] = $fcInfo['emp_code'];
    $staffName[]['staff_name'] = $fcInfo['staff_name'];
}
}
//FC Ins END //

}else{
    $mapid[]['id'] = '';
    $workid[]['work_id'] = '';
    $tasktitle[]['title'] = '';
    $worksts[]['sts'] = '';
    $fromdt[]['f_date'] = '';
    $todt[]['t_date'] = '';
    $completedFile[]['com_file'] = '';
}

for ($i=0; $i<count($mapid); $i++) { 

    if($worksts[$i]['sts'] == '0'){ $sts = 'Work Assigned';}
    if($worksts[$i]['sts'] == '1'){ $sts = 'In-Progress';}
    if($worksts[$i]['sts'] == '2'){ $sts = 'Pending';}
    if($worksts[$i]['sts'] == '3'){ $sts = 'Completed';}

    if($completedFile[$i]['com_file'] != ''){ //if com_file is empty then '-' will show.
        $comFile = $completedFile[$i]['com_file'];
    }else{
        $comFile ='-';
    }

?>    

    <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo $staffCode[$i]['emp_code']; ?></td>
        <td><?php echo $staffName[$i]['staff_name']; ?></td>
        <td><?php echo $tasktitle[$i]['title']; ?></td>
        <td><?php echo $fromdt[$i]['f_date']; ?></td>
        <td><?php echo $todt[$i]['t_date']; ?></td>
        <td><?php echo $sts; ?></td>
        <td> <a href="uploads\completedTaskFile\<?php echo $comFile; ?>" target="_blank"> <?php echo $comFile; ?> </a> </td>
    </tr>

<?php }  ?>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $('#staff_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "createdRow": function(row, data, dataIndex) {
                $(row).find('td:first').html(dataIndex + 1);
            },
            "drawCallback": function(settings) {
                this.api().column(0).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            },
            "order": [[1, 'asc']] // Order by the second column (staff name) in ascending order
        });
    });
</script>