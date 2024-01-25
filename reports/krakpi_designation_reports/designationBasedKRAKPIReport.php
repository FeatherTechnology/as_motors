<?php
include '../../ajaxconfig.php';
@session_start();
if(isset($_SESSION['curdateFromIndexPage'])){
    $curdate = $_SESSION['curdateFromIndexPage'];
}
//krakpi.\\         ////designation based.
$designation_id = '0';
if(isset($_POST["designation_id"])){
    $designation_id = ($_POST["designation_id"]);
}

$getStaffQry = $connect->query("select * from staff_creation where designation = '$designation_id' and status = '0' ");
if($getStaffQry->rowCount() > 0){ //Report show only if staff creation completed against the designation. if not then no report will show.
    $staffinfo = $getStaffQry->fetch();
    $staffid = $staffinfo['staff_id'];
?>

<!-- Responsibility Table START -->
<!-- <div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="reponsibility_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> Reponsibility </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="reponsibility_report_data">
    <thead>
        <tr>
            <th width="15%">S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Responsibility</th>
        </tr>
    </thead>
    <tbody>

<?php
// $res_emp_code = array();
// $res_staff_name = array();
// $res = array();

// if($designation_id != '0'){

// $resqry = "";
// $resqry = "SELECT sc.emp_code, sc.staff_name, rc.responsibility_name 
// FROM `basic_creation` bc 
// JOIN staff_creation sc ON sc.designation = $designation_id
// JOIN responsibility_creation rc ON FIND_IN_SET(rc.responsibility_id, bc.responsibility)
// WHERE FIND_IN_SET($designation_id, bc.designation) && sc.status = 0";

// $resInfo = $connect->query($resqry);
// if($resInfo -> rowCount() > 0){
    
// while ($restask = $resInfo->fetch()) { 

//     $res_emp_code[]['emp_code'] = $restask['emp_code'];
//     $res_staff_name[]['staff_name'] = $restask['staff_name'];
//     $res[]['responsibility_name'] = $restask['responsibility_name'];
//     }
// }

// } else{
//     $res_emp_code[]['emp_code'] = '';
//     $res_staff_name[]['staff_name'] = '';
//     $res[]['responsibility_name'] = '';
// }

// $a = 1;
// for ($i=0; $i<count($res); $i++) { 
?>    
    <tr>
        <td><?php #echo $a++; ?></td>
        <td><?php #echo $res_emp_code[$i]['emp_code']; ?></td>
        <td><?php #echo $res_staff_name[$i]['staff_name']; ?></td>
        <td><?php #echo $res[$i]['responsibility_name']; ?></td>
    </tr>
<?php //}  ?>
    </tbody>
</table> -->
<!-- Responsibility Table END -->

<!-- Daily Task Table START -->
<!-- </br></br></br>
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="dailytask_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5>Daily Task </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="dailytask_data">
    <thead>
        <tr>
            <th width="15%">S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Title</th>
            <th>Work Description</th>
        </tr>
    </thead>
    <tbody> -->

<?php
// $dailyTaskWorkId = array();
// $dailyTasktitle = array();
// $empcode = array();
// $staffname = array();
// if($designation_id != '0'){

//     $qry = "";

//     $qry = "SELECT 'KRA & KPI' as work_id, DATE(kcr.from_date) as f_date, DATE(kcr.to_date) as t_date, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as title, sc.emp_code, sc.staff_name  
//             FROM `krakpi_creation` kc 
//             LEFT JOIN krakpi_creation_ref kcr ON kc.krakpi_id = kcr.krakpi_reff_id 
//             LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
//             LEFT JOIN staff_creation sc ON kc.designation = sc.designation AND sc.status = 0
//             WHERE kc.status = 0 
//             AND kc.designation = '".$designation_id."' 
//             AND kcr.frequency ='Daily Task' ";
    
//     $krakpiInfo = $connect->query($qry);
//     if($krakpiInfo){
        
//     while ($krakpitask = $krakpiInfo->fetch()) { 
    
//         $dailyTaskWorkId[]['work_id'] = $krakpitask['work_id'];
//         $dailyTasktitle[]['title'] = $krakpitask['title'];
//         $empcode[]['empCode'] = $krakpitask['emp_code'];
//         $staffname[]['staffName'] = $krakpitask['staff_name'];
//         }
//     }
//     //KRAKPI END//
    
//     //Audit start//
//     $auditTaskInfo ="SELECT 'AUDIT ' as work_id, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM audit_area_creation_ref acr 
//     LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
//     LEFT JOIN staff_creation sc1 ON ac.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON ac.role2 = sc2.designation AND sc2.status = 0
//     WHERE ac.status = 0 AND (ac.role1 = '".$designation_id."' OR ac.role2 = '".$designation_id."') 
//     AND ac.frequency = 'Daily Task' ";
    
//     $auditInfo = $connect->query($auditTaskInfo);
//     if($auditInfo){
        
//     while ($audittask = $auditInfo->fetch()) { 

//         $dailyTaskWorkId[]['work_id'] = $audittask['work_id'];
//         $dailyTasktitle[]['title'] = $audittask['title'];
//         $empcode[]['empCode'] = $audittask['emp_code'];
//         $staffname[]['staffName'] = $audittask['staff_name'];
//     }   
//     } 
//     //Audit END//
    
//     //Maintance start//          
//     $maintanceTaskInfo = "SELECT 'PM MAINTENANCE '  as work_id, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM pm_checklist_ref pcr 
//     LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
//     LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
//     LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id
//     LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0 
//     WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
//     AND pc.frequency = 'Daily Task' ";

//     $maintanceInfo = $connect->query($maintanceTaskInfo);
//     if($maintanceInfo){
//     while ($maintancetask = $maintanceInfo->fetch()) { 

//         $dailyTaskWorkId[]['work_id'] = $maintancetask['work_id'];
//         $dailyTasktitle[]['title'] = $maintancetask['title'];
//         $empcode[]['empCode'] = $maintancetask['emp_code'];
//         $staffname[]['staffName'] = $maintancetask['staff_name'];
//     }
//     } 
//     //Maintance END//
    
//     //BM Start//
//     $bmTaskInfo = "SELECT 'BM MAINTENANCE ' as work_id, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM bm_checklist_ref bcr 
//     LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
//     LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
//     LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
//     LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0  
//     WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
//     AND bc.frequency = 'Daily Task' ";

//     $bmInfo = $connect->query($bmTaskInfo);
//     if($bmInfo){
//     while ($bmtask = $bmInfo->fetch()) { 

//         $dailyTaskWorkId[]['work_id'] = $bmtask['work_id'];
//         $dailyTasktitle[]['title'] = $bmtask['title'];
//         $empcode[]['empCode'] = $bmtask['emp_code'];
//         $staffname[]['staffName'] = $bmtask['staff_name'];
//     }
//     }
//     //BM END//
    
// }//designation //if condition END.
    
//     for ($i=0; $i<count($dailyTasktitle); $i++) {    
    ?>      
        <!-- <tr>
            <td><?php #echo $i+1; ?></td>
            <td><?php #echo $empcode[$i]['empCode']; ?></td>
            <td><?php #echo $staffname[$i]['staffName']; ?></td>
            <td><?php #echo $dailyTaskWorkId[$i]['work_id']; ?></td>
            <td><?php #echo $dailyTasktitle[$i]['title']; ?></td>
        </tr> -->
    
    <?php #}  ?>
    <!-- </tbody>
</table> -->
<!-- Daily Task Table END -->

<!-- Task Table START -->
<!-- </br></br></br>
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="task_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> Task </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="task_data">
    <thead>
        <tr>
            <th width="15%">S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Title</th>
            <th>Work Description</th>
            <th>From Date</th>
            <th>To Date</th>
        </tr>
    </thead>
    <tbody> -->

<?php
// $taskWorkId = array();
// $tasktitle = array();
// $fromdt = array();
// $todt = array();
// $empcode = array();
// $staffname = array();
// if($designation_id != '0'){

//     $qry = "";

//     $qry = "SELECT 'KRA & KPI' as work_id, DATE(kcr.from_date) as f_date, DATE(kcr.to_date) as t_date, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as title, sc.emp_code, sc.staff_name  
//             FROM `krakpi_creation` kc 
//             LEFT JOIN krakpi_creation_ref kcr ON kc.krakpi_id = kcr.krakpi_reff_id 
//             LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
//             LEFT JOIN staff_creation sc ON kc.designation = sc.designation AND sc.status = 0
//             WHERE kc.status = 0 
//             AND kc.designation = '".$designation_id."' 
//             AND 
//             ( 
//                 YEAR(kcr.from_date) = YEAR(CURRENT_DATE)
//                 OR 
//                 YEAR(kcr.to_date) = YEAR(CURRENT_DATE)
//             ) ";
    
//     $krakpiInfo = $connect->query($qry);
//     if($krakpiInfo){
        
//     while ($krakpitask = $krakpiInfo->fetch()) { 
    
//         $taskWorkId[]['work_id'] = $krakpitask['work_id'];
//         $tasktitle[]['title'] = $krakpitask['title'];
//         $fromdt[]['f_date'] = $krakpitask['f_date'];
//         $todt[]['t_date'] = $krakpitask['t_date'];
//         $empcode[]['empCode'] = $krakpitask['emp_code'];
//         $staffname[]['staffName'] = $krakpitask['staff_name'];
//         }
//     }
//     //KRAKPI END//
    
//     //Audit start//
//     $auditTaskInfo ="SELECT 'AUDIT ' as work_id, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM audit_area_creation_ref acr 
//     LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
//     LEFT JOIN staff_creation sc1 ON ac.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON ac.role2 = sc2.designation AND sc2.status = 0
//     WHERE ac.status = 0 AND (ac.role1 = '".$designation_id."' OR ac.role2 = '".$designation_id."') 
//     AND 
//     ( 
//         YEAR(acr.from_date) = YEAR(CURRENT_DATE)
//     OR
//         YEAR(acr.to_date) = YEAR(CURRENT_DATE)
//     )";
    
//     $auditInfo = $connect->query($auditTaskInfo);
//     if($auditInfo){
        
//     while ($audittask = $auditInfo->fetch()) { 

//         $taskWorkId[]['work_id'] = $audittask['work_id'];
//         $tasktitle[]['title'] = $audittask['title'];
//         $fromdt[]['f_date'] = $audittask['f_date'];
//         $todt[]['t_date'] = $audittask['t_date'];
//         $empcode[]['empCode'] = $audittask['emp_code'];
//         $staffname[]['staffName'] = $audittask['staff_name'];
//     }   
//     } 
//     //Audit END//
    
//     //Maintance start//          
//     $maintanceTaskInfo = "SELECT 'PM MAINTENANCE '  as work_id, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM pm_checklist_ref pcr 
//     LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
//     LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
//     LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id
//     LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0 
//     WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
//     AND 
//     ( 
//         YEAR(pcr.from_date) = YEAR(CURRENT_DATE) 
//     OR
//         YEAR(pcr.to_date) = YEAR(CURRENT_DATE) 
//     )";
//     $maintanceInfo = $connect->query($maintanceTaskInfo);
//     if($maintanceInfo){
//     while ($maintancetask = $maintanceInfo->fetch()) { 

//         $taskWorkId[]['work_id'] = $maintancetask['work_id'];
//         $tasktitle[]['title'] = $maintancetask['title'];
//         $fromdt[]['f_date'] = $maintancetask['f_date'];
//         $todt[]['t_date'] = $maintancetask['t_date'];
//         $empcode[]['empCode'] = $maintancetask['emp_code'];
//         $staffname[]['staffName'] = $maintancetask['staff_name'];
//     }
//     } 
//     //Maintance END//
    
//     //BM Start//
//     $bmTaskInfo = "SELECT 'BM MAINTENANCE ' as work_id, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
//     FROM bm_checklist_ref bcr 
//     LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
//     LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
//     LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
//     LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
//     LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0  
//     WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
//     AND 
//     ( 
//         YEAR(bcr.from_date) = YEAR(CURRENT_DATE) 
//     OR
//         YEAR(bcr.to_date) = YEAR(CURRENT_DATE) 
//     )";
//     $bmInfo = $connect->query($bmTaskInfo);
//     if($bmInfo){
//     while ($bmtask = $bmInfo->fetch()) { 

//         $taskWorkId[]['work_id'] = $bmtask['work_id'];
//         $tasktitle[]['title'] = $bmtask['title'];
//         $fromdt[]['f_date'] = $bmtask['f_date'];
//         $todt[]['t_date'] = $bmtask['t_date'];
//         $empcode[]['empCode'] = $bmtask['emp_code'];
//         $staffname[]['staffName'] = $bmtask['staff_name'];
//     }
//     }
//     //BM END//
    
//     //campaign Start//
//     $campaignTaskInfo = "SELECT 'CAMPAIGN ' as work_id, cf.activity_involved as title, DATE(cf.start_date) as f_date, DATE(cf.end_date) as t_date, sc.emp_code, sc.staff_name 
//     FROM campaign_ref cf 
//     LEFT JOIN campaign c ON cf.campaign_id = c.campaign_id
//     LEFT JOIN staff_creation sc ON cf.employee_name = sc.staff_id AND sc.status = 0 
//     WHERE c.status = 0 AND FIND_IN_SET('$staffid', employee_name) > 0 
//     AND 
//     ( 
//         YEAR(cf.start_date) = YEAR(CURRENT_DATE)
//     OR
//         YEAR(cf.end_date) = YEAR(CURRENT_DATE)
//     ) ";
//     $campaignInfo = $con->query($campaignTaskInfo);
//     if($campaignInfo){
//     while($campaigntask = $campaignInfo->fetch_assoc()) {

//         $taskWorkId[]['work_id'] = $campaigntask['work_id'];
//         $tasktitle[]['title'] = $campaigntask['title'];
//         $fromdt[]['f_date'] = $campaigntask['f_date'];
//         $todt[]['t_date'] = $campaigntask['t_date'];
//         $empcode[]['empCode'] = $campaigntask['emp_code'];
//         $staffname[]['staffName'] = $campaigntask['staff_name'];
//     }
//     }
//     //campaign END//
    
//     //assign work list Start//
//     $assignedTaskInfo = "SELECT 'ASSIGNED WORK ' as work_id, ref_id as id, work_status as sts, work_des_text as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name 
//     FROM assign_work_ref awf 
//     LEFT JOIN staff_creation sc ON awf.designation_id = sc.designation AND sc.status = 0 
//     WHERE awf.status = 0 AND awf.designation_id = '".$designation_id."'
//     AND 
//         ( 
//             YEAR(from_date) = YEAR(CURRENT_DATE) 
//         OR
//             YEAR(to_date) = YEAR(CURRENT_DATE) 
//         )
//         GROUP BY work_des_text "; 
//     $assignInfo = $con->query($assignedTaskInfo);
//     if($assignInfo){
//     while($assignTask = $assignInfo->fetch_assoc()) { 

//         $taskWorkId[]['work_id'] = $assignTask['work_id'];
//         $tasktitle[]['title'] = $assignTask['title'];
//         $fromdt[]['f_date'] = $assignTask['f_date'];
//         $todt[]['t_date'] = $assignTask['t_date'];
//         $empcode[]['empCode'] = $assignTask['emp_code'];
//         $staffname[]['staffName'] = $assignTask['staff_name'];
//     }
//     }
//     //assign work list END//
    
//     //Todo Start //
//     $todoqry = "SELECT 'TODO ' as work_id, work_des as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name
//     FROM todo_creation tc
//     LEFT JOIN staff_creation sc ON tc.assign_to = sc.staff_id AND sc.status = 0 
//     WHERE tc.status = 0 AND FIND_IN_SET('$staffid', assign_to) > 0 AND 
//     ( 
//         YEAR(from_date) = YEAR(CURRENT_DATE) 
//     OR
//         YEAR(to_date) = YEAR(CURRENT_DATE) 
//     )  ";
//     $gettodoinfo = $con->query($todoqry);
//     if($gettodoinfo){
//     while($todoinfo = $gettodoinfo->fetch_assoc()){

//         $taskWorkId[]['work_id'] = $todoinfo['work_id'];
//         $tasktitle[]['title'] = $todoinfo['title'];
//         $fromdt[]['f_date'] = $todoinfo['f_date'];
//         $todt[]['t_date'] = $todoinfo['t_date'];
//         $empcode[]['empCode'] = $todoinfo['emp_code'];
//         $staffname[]['staffName'] = $todoinfo['staff_name'];
//     }
//     }
//     //ToDo END //
    
//     //Insurance Register Start //
//     $insqry = "SELECT 'INSURANCE REGISTER ' as work_id, DATE(irr.from_date) as f_date, DATE(irr.to_date) as t_date,ir.insurance_id as ins_id, sc.emp_code, sc.staff_name
//     FROM insurance_register_ref irr 
//     LEFT JOIN insurance_register ir ON irr.ins_reg_id = ir.ins_reg_id
//     LEFT JOIN staff_creation sc ON ir.designation_id = sc.designation AND sc.status = 0  
//     WHERE ir.status = 0 
//     AND ir.designation_id = '".$designation_id."' 
//     AND 
//     ( 
//         YEAR(irr.from_date) = YEAR(CURRENT_DATE)
//     OR
//         YEAR(irr.to_date) = YEAR(CURRENT_DATE) 
//     ) ";  
    
//     $insdeatils = $con->query($insqry);
//     if($insdeatils){
//     while($insInfo = $insdeatils->fetch_assoc()){
//         $inscreation = $con->query("SELECT insurance_name FROM insurance_creation WHERE status = 0 AND insurance_id = '". $insInfo["ins_id"]."' ");
//         $inscrtion = $inscreation->fetch_assoc();
//             $insurance_name = $inscrtion["insurance_name"];

//         $taskWorkId[]['work_id'] = $insInfo['work_id'];
//         $tasktitle[]['title'] = $insurance_name;
//         $fromdt[]['f_date'] = $insInfo['f_date'];
//         $todt[]['t_date'] = $insInfo['t_date'];
//         $empcode[]['empCode'] = $insInfo['emp_code'];
//         $staffname[]['staffName'] = $insInfo['staff_name'];
//     }
//     }
//     //Insurance Register END //
    
//     //FC Ins Start //
//     $fc_ins_details = $con->query("SELECT 'FC INSURANCE RENEWAL ' as work_id, fc_insurance_renew_id as id, work_status as sts, assign_remark as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name 
//     FROM fc_insurance_renew fir
//     LEFT JOIN staff_creation sc ON fir.assign_staff_name = sc.staff_id AND sc.status = 0  
//     WHERE fir.status = 0 AND FIND_IN_SET('$staffid', assign_staff_name) > 0  
//     AND 
//     ( 
//         YEAR(from_date) = YEAR(CURRENT_DATE)
//     OR
//         YEAR(to_date) = YEAR(CURRENT_DATE)
//     ) ");
//     while($fcInfo = $fc_ins_details->fetch_assoc()){
        
//         $taskWorkId[]['work_id'] = $fcInfo['work_id'];
//         $tasktitle[]['title'] = $fcInfo['title'];
//         $fromdt[]['f_date'] = $fcInfo['f_date'];
//         $todt[]['t_date'] = $fcInfo['t_date'];
//         $empcode[]['empCode'] = $fcInfo['emp_code'];
//         $staffname[]['staffName'] = $fcInfo['staff_name'];
//     }
//     //FC Ins END //
    
// }//designation //if condition END.
    
//     for ($i=0; $i<count($tasktitle); $i++) {    
    ?>      
        <!-- <tr>
            <td><?php #echo $i+1; ?></td>
            <td><?php #echo $empcode[$i]['empCode']; ?></td>
            <td><?php #echo $staffname[$i]['staffName']; ?></td>
            <td><?php #echo $taskWorkId[$i]['work_id']; ?></td>
            <td><?php #echo $tasktitle[$i]['title']; ?></td>
            <td><?php #echo $fromdt[$i]['f_date']; ?></td>
            <td><?php #echo $todt[$i]['t_date']; ?></td>
        </tr> -->
    
    <?php #}  ?>
    <!-- </tbody>
</table> -->
<!-- Task Table END -->

<!-- Daily Task Table START -->
<!-- </br></br></br> -->
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="dailytask_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> Daily Task Report </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="dailytask_report_data">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Frequency</th>
            <th>KRA Category</th>
            <th>R & R</th>
            <th>Date of Task</th>
            <th>Current Status</th>
            <th>Completed File</th>
        </tr>
    </thead>
    <tbody>

<?php
$dailyworkid = array();
$dailyemp_code = array();
$dailystaff_name = array();
$dailyfrequency = array();
$dailykra = array();
$dailyrr = array();
$dailyfrom_date = array();
$dailyto_date = array();
$dailyworksts = array();
$dailycompletedFile = array();

if($designation_id != '0'){
// $dailytaskqry = "";
$dailytaskqry = "SELECT 'KRA & KPI' as work_id, sc.emp_code, sc.staff_name, kcr.frequency, kra.kra_category, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as RR,  DATE(kcm.from_date) as f_date, DATE(kcm.to_date) as t_date, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts
FROM krakpi_calendar_map kcm 
LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id 
LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id 
LEFT JOIN kra_creation_ref kra ON kcr.kra_category = kra.kra_creation_ref_id
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
WHERE kc.designation = '$designation_id' && kc.status = 0 && kcr.frequency = 'Daily Task' && date(kcm.from_date) <= '$curdate' && sc.status = 0";

$dailytaskInfo = $connect->query($dailytaskqry);
if($dailytaskInfo -> rowCount() > 0){
    
while ($dailytask = $dailytaskInfo->fetch()) { 

    $dailykrakpi_id = 'krakpi_ref '.$dailytask['id'];
    $dailykrakpimapdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$dailykrakpi_id."' ");
    if(mysqli_num_rows($dailykrakpimapdetails)>0){ //checks if the row > 0 then show completed_file else empty.
    $dailykrakpimap = $dailykrakpimapdetails->fetch_assoc();  
        $dailykrakpicompletedfile = $dailykrakpimap["completed_file"];
    }else{
        $dailykrakpicompletedfile = '';
    }

    $dailyworkid[]['work_id'] = $dailytask['work_id'];
    $dailyemp_code[]['emp_code'] = $dailytask['emp_code'];
    $dailystaff_name[]['staff_name'] = $dailytask['staff_name'];
    $dailyfrequency[]['frequency'] = $dailytask['frequency'];
    $dailykra[]['kra_category'] = $dailytask['kra_category'];
    $dailyrr[]['RR'] = $dailytask['RR'];
    $dailyfrom_date[]['from_date'] = $dailytask['f_date'];
    $dailyto_date[]['to_date'] = $dailytask['t_date'];
    $dailyworksts[]['sts'] = $dailytask['sts'];
    $dailycompletedFile[]['com_file'] = $dailykrakpicompletedfile;
    }
}

} else{
    $dailyworkid[]['work_id'] = '';
    $dailyemp_code[]['emp_code'] = '';
    $dailystaff_name[]['staff_name'] = '';
    $dailyfrequency[]['frequency'] = '';
    $dailykra[]['kra_category'] = '';
    $dailyrr[]['RR'] = '';
    $dailyfrom_date[]['from_date'] = '';
    $dailyto_date[]['to_date'] = '';
    $dailyworksts[]['sts'] = '';
    $dailycompletedFile[]['com_file'] = '';
}

$a = 1;
for ($i=0; $i<count($dailykra); $i++) { 
    if($dailyworksts[$i]['sts'] == '0'){ $sts = 'Work Assigned';}
    if($dailyworksts[$i]['sts'] == '1'){ $sts = 'In-Progress';}
    if($dailyworksts[$i]['sts'] == '2'){ $sts = 'Pending';}
    if($dailyworksts[$i]['sts'] == '3'){ $sts = 'Completed';}

    if($dailycompletedFile[$i]['com_file'] != ''){ //if com_file is empty then '-' will show.
        $comFile = $dailycompletedFile[$i]['com_file'];
    }else{
        $comFile ='-';
    }
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $dailyemp_code[$i]['emp_code']; ?></td>
        <td><?php echo $dailystaff_name[$i]['staff_name']; ?></td>
        <td><?php echo $dailyfrequency[$i]['frequency']; ?></td>
        <td><?php echo $dailykra[$i]['kra_category']; ?></td>
        <td><?php echo $dailyrr[$i]['RR']; ?></td>
        <td><?php echo $dailyfrom_date[$i]['from_date']; ?></td>
        <td><?php echo $sts; ?></td>
        <td> <a href="uploads\completedTaskFile\<?php echo $comFile; ?>" target="_blank"> <?php echo $comFile; ?> </a> </td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Daily Task Table END -->

<!-- calendar Task (KRAKPI, TODO) Table START -->
</br></br></br>
<div class="row">
    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <input type="button" name="page_print" id="page_print" class="btn btn-danger print-page " data-id="calendartask_report_data" value="PRINT">
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
        <div class="form-group">
            <h5> KRAKPI & TODO Report </h5>
        </div>
    </div>
</div>
<table class="table custom-table" id="calendartask_report_data">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Emp Code</th>
            <th>Staff Name</th>
            <th>Task Name</th>
            <th>Frequency</th>
            <th>KRA Category</th>
            <th>R & R</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Current Status</th>
            <th>Completed File</th>
        </tr>
    </thead>
    <tbody>

<?php
$workid = array();
$emp_code = array();
$staff_name = array();
$frequency = array();
$kra = array();
$rr = array();
$from_date = array();
$to_date = array();
$worksts = array();
$completedFile = array();

if($designation_id != '0'){//KRAKPI 
//KRAKPI start//
// $qry = "";
$qry = "SELECT 'KRA & KPI' as work_id, sc.emp_code, sc.staff_name, kcr.frequency, kra.kra_category, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as RR,  DATE(kcm.from_date) as f_date, DATE(kcm.to_date) as t_date, kcm.krakpi_calendar_map_id as id, kcm.work_status as sts
FROM krakpi_calendar_map kcm 
LEFT JOIN krakpi_creation kc ON kcm.krakpi_id = kc.krakpi_id 
LEFT JOIN krakpi_creation_ref kcr ON kcm.krakpi_ref_id = kcr.krakpi_ref_id 
LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id 
LEFT JOIN kra_creation_ref kra ON kcr.kra_category = kra.kra_creation_ref_id
LEFT JOIN staff_creation sc ON kc.designation = sc.designation
WHERE kc.designation = '$designation_id' && kc.status = 0 && kcr.frequency != 'Daily Task' && sc.status = 0";

$krakpiInfo = $connect->query($qry);
if($krakpiInfo -> rowCount() > 0){
    
while ($krakpitask = $krakpiInfo->fetch()) { 

    $krakpi_id = 'krakpi_ref '.$krakpitask['id'];
    $krakpimapdetails = $con->query("SELECT completed_file FROM work_status WHERE work_id = '".$krakpi_id."' ");
    if(mysqli_num_rows($krakpimapdetails)>0){ //checks if the row > 0 then show completed_file else empty.
    $krakpimap = $krakpimapdetails->fetch_assoc();  
        $krakpi_completed_file = $krakpimap["completed_file"];
    }else{
        $krakpi_completed_file = '';
    }

    $workid[]['work_id'] = $krakpitask['work_id'];
    $emp_code[]['emp_code'] = $krakpitask['emp_code'];
    $staff_name[]['staff_name'] = $krakpitask['staff_name'];
    $frequency[]['frequency'] = $krakpitask['frequency'];
    $kra[]['kra_category'] = $krakpitask['kra_category'];
    $rr[]['RR'] = $krakpitask['RR'];
    $from_date[]['from_date'] = $krakpitask['f_date'];
    $to_date[]['to_date'] = $krakpitask['t_date'];
    $worksts[]['sts'] = $krakpitask['sts'];
    $completedFile[]['com_file'] = $krakpi_completed_file;
    }
}
//KRAKPI END//

//Todo Start //
$todoqry = "SELECT 'TODO ' as work_id, tc.todo_id as id, tc.work_status as sts, tc.work_des as RR, DATE(tc.from_date) as f_date, DATE(tc.to_date) as t_date, sc.staff_name, sc.emp_code
FROM todo_creation tc 
LEFT JOIN staff_creation sc ON FIND_IN_SET(sc.staff_id, tc.assign_to)
WHERE sc.designation = '$designation_id' &&  tc.status = 0 && sc.status = 0";

$gettodoinfo = $con->query($todoqry);
if(mysqli_num_rows($gettodoinfo) > 0){
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

    $workid[]['work_id'] = $todoinfo['work_id'];
    $emp_code[]['emp_code'] = $todoinfo['emp_code'];
    $staff_name[]['staff_name'] = $todoinfo['staff_name'];
    $frequency[]['frequency'] = '-';
    $kra[]['kra_category'] = '-';
    $rr[]['RR'] = $todoinfo['RR'];
    $from_date[]['from_date'] = $todoinfo['f_date'];
    $to_date[]['to_date'] = $todoinfo['t_date'];
    $worksts[]['sts'] = $todoinfo['sts'];
    $completedFile[]['com_file'] = $todo_completed_file;
}
}
//ToDo END //

} else{
    $workid[]['work_id'] = '';
    $emp_code[]['emp_code'] = '';
    $staff_name[]['staff_name'] = '';
    $frequency[]['frequency'] = '';
    $kra[]['kra_category'] = '';
    $rr[]['RR'] = '';
    $from_date[]['from_date'] = '';
    $to_date[]['to_date'] = '';
    $worksts[]['sts'] = '';
    $completedFile[]['com_file'] = '';
}

$a = 1;
for ($i=0; $i<count($kra); $i++) { 
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
        <td><?php echo $a++; ?></td>
        <td><?php echo $emp_code[$i]['emp_code']; ?></td>
        <td><?php echo $staff_name[$i]['staff_name']; ?></td>
        <td><?php echo $workid[$i]['work_id']; ?></td>
        <td><?php echo $frequency[$i]['frequency']; ?></td>
        <td><?php echo $kra[$i]['kra_category']; ?></td>
        <td><?php echo $rr[$i]['RR']; ?></td>
        <td><?php echo $from_date[$i]['from_date']; ?></td>
        <td><?php echo $to_date[$i]['to_date']; ?></td>
        <td><?php echo $sts; ?></td>
        <td> <a href="uploads\completedTaskFile\<?php echo $comFile; ?>" target="_blank"> <?php echo $comFile; ?> </a> </td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Calendar Task (KRAKPI, TODO) Table END -->

<script type="text/javascript">
    $(function() {
        // $('#reponsibility_report_data').DataTable({
        //     'processing': true,
        //     'iDisplayLength': 20,
        //     "lengthMenu": [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, "All"]
        //     ],
        //     dom: 'lBfrtip',
        //     buttons: [
        //         {
        //             extend: 'csv',
        //             exportOptions: {
        //                 columns: [ 0, 1, 2, 3 ]
        //             }
        //         }
        //     ],
        // });

        // $('#dailytask_data').DataTable({
        //     'processing': true,
        //     'iDisplayLength': 20,
        //     "lengthMenu": [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, "All"]
        //     ],
        //     dom: 'lBfrtip',
        //     buttons: [
        //         {
        //             extend: 'csv',
        //             exportOptions: {
        //                 columns: [ 0, 1, 2, 3, 4 ]
        //             }
        //         }
        //     ],
        // });

        // $('#task_data').DataTable({
        //     'processing': true,
        //     'iDisplayLength': 20,
        //     "lengthMenu": [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, "All"]
        //     ],
        //     dom: 'lBfrtip',
        //     buttons: [
        //         {
        //             extend: 'csv',
        //             exportOptions: {
        //                 columns: [ 0, 1, 2, 3, 4, 5, 6 ]
        //             }
        //         }
        //     ],
        // });

        $('#dailytask_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
        });

        $('#calendartask_report_data').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                    }
                }
            ],
        });

    });

    $('.print-page').click(function (e){
        e.preventDefault();

        const tableId = $(this).data('id');
        const table = document.getElementById(tableId);

        if (table) {

            // if(tableId == 'reponsibility_report_data'){
            //     title = 'Responsibility Report';

            // }else 
            if(tableId == 'dailytask_report_data'){
                title = 'Daily Task Report';
                
            }else if(tableId == 'calendartask_report_data'){
                title = 'KRAKPI & TODO Report';
                
            }else{
                title = 'Report';

            }
            // Clone the table to avoid modifying the original table
            const tableClone = table.cloneNode(true);
        
            // Create a new window to print the modified table
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<html><head><title>Print Table</title></head><body>');
            newWindow.document.write('<h4> '+ title + '</h4>');
            newWindow.document.write('<style>table { border-collapse: collapse; } td, th { border: 1px solid black; padding: 8px; }</style>');
            newWindow.document.write(tableClone.outerHTML);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
        
            // Wait for a small delay to allow the table to be rendered in the new window
            setTimeout(function() {
            newWindow.print();
            newWindow.close();
            }, 1000); // Adjust the delay time as needed
        } else {
            console.error('Table not found.');
        }
    }); //Print END///

</script>

<?php }else{
    ?>
    <!-- <div class="row col-12"> <div class="center">There is no staff creation against the Designation!</div></div> -->
    <script>  alert('Please complete the staff creation process for this designation.'); </script>
    <?php
} ?>