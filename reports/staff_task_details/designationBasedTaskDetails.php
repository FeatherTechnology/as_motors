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
<div class="row">
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
$res_emp_code = array();
$res_staff_name = array();
$res = array();

if($designation_id != '0'){

$resqry = "";
$resqry = "SELECT sc.emp_code, sc.staff_name, rc.responsibility_name 
FROM `basic_creation` bc 
JOIN staff_creation sc ON sc.designation = $designation_id
JOIN responsibility_creation rc ON FIND_IN_SET(rc.responsibility_id, bc.responsibility)
WHERE FIND_IN_SET($designation_id, bc.designation) && sc.status = 0";

$resInfo = $connect->query($resqry);
if($resInfo -> rowCount() > 0){
    
while ($restask = $resInfo->fetch()) { 

    $res_emp_code[]['emp_code'] = $restask['emp_code'];
    $res_staff_name[]['staff_name'] = $restask['staff_name'];
    $res[]['responsibility_name'] = $restask['responsibility_name'];
    }
}

} else{
    $res_emp_code[]['emp_code'] = '';
    $res_staff_name[]['staff_name'] = '';
    $res[]['responsibility_name'] = '';
}

$a = 1;
for ($i=0; $i<count($res); $i++) { 
?>    
    <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $res_emp_code[$i]['emp_code']; ?></td>
        <td><?php echo $res_staff_name[$i]['staff_name']; ?></td>
        <td><?php echo $res[$i]['responsibility_name']; ?></td>
    </tr>
<?php }  ?>
    </tbody>
</table>
<!-- Responsibility Table END -->

<!-- Daily Task Table START -->
</br></br></br>
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
    <tbody>

<?php
$dailyTaskWorkId = array();
$dailyTasktitle = array();
$empcode = array();
$staffname = array();
if($designation_id != '0'){

    $qry = "";

    $qry = "SELECT 'KRA & KPI' as work_id, DATE(kcr.from_date) as f_date, DATE(kcr.to_date) as t_date, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as title, sc.emp_code, sc.staff_name  
            FROM `krakpi_creation` kc 
            LEFT JOIN krakpi_creation_ref kcr ON kc.krakpi_id = kcr.krakpi_reff_id 
            LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
            LEFT JOIN staff_creation sc ON kc.designation = sc.designation AND sc.status = 0
            WHERE kc.status = 0 
            AND kc.designation = '".$designation_id."' 
            AND kcr.frequency ='Daily Task' ";
    
    $krakpiInfo = $connect->query($qry);
    if($krakpiInfo){
        
    while ($krakpitask = $krakpiInfo->fetch()) { 
    
        $dailyTaskWorkId[]['work_id'] = $krakpitask['work_id'];
        $dailyTasktitle[]['title'] = $krakpitask['title'];
        $empcode[]['empCode'] = $krakpitask['emp_code'];
        $staffname[]['staffName'] = $krakpitask['staff_name'];
        }
    }
    //KRAKPI END//
    
    //Audit start//
    $auditTaskInfo ="SELECT 'AUDIT ' as work_id, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM audit_area_creation_ref acr 
    LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
    LEFT JOIN staff_creation sc1 ON ac.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON ac.role2 = sc2.designation AND sc2.status = 0
    WHERE ac.status = 0 AND (ac.role1 = '".$designation_id."' OR ac.role2 = '".$designation_id."') 
    AND ac.frequency = 'Daily Task' ";
    
    $auditInfo = $connect->query($auditTaskInfo);
    if($auditInfo){
        
    while ($audittask = $auditInfo->fetch()) { 

        $dailyTaskWorkId[]['work_id'] = $audittask['work_id'];
        $dailyTasktitle[]['title'] = $audittask['title'];
        $empcode[]['empCode'] = $audittask['emp_code'];
        $staffname[]['staffName'] = $audittask['staff_name'];
    }   
    } 
    //Audit END//
    
    //Maintance start//          
    $maintanceTaskInfo = "SELECT 'PM MAINTENANCE '  as work_id, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM pm_checklist_ref pcr 
    LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
    LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
    LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id
    LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0 
    WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
    AND pc.frequency = 'Daily Task' ";

    $maintanceInfo = $connect->query($maintanceTaskInfo);
    if($maintanceInfo){
    while ($maintancetask = $maintanceInfo->fetch()) { 

        $dailyTaskWorkId[]['work_id'] = $maintancetask['work_id'];
        $dailyTasktitle[]['title'] = $maintancetask['title'];
        $empcode[]['empCode'] = $maintancetask['emp_code'];
        $staffname[]['staffName'] = $maintancetask['staff_name'];
    }
    } 
    //Maintance END//
    
    //BM Start//
    $bmTaskInfo = "SELECT 'BM MAINTENANCE ' as work_id, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM bm_checklist_ref bcr 
    LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
    LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
    LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
    LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0  
    WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
    AND bc.frequency = 'Daily Task' ";

    $bmInfo = $connect->query($bmTaskInfo);
    if($bmInfo){
    while ($bmtask = $bmInfo->fetch()) { 

        $dailyTaskWorkId[]['work_id'] = $bmtask['work_id'];
        $dailyTasktitle[]['title'] = $bmtask['title'];
        $empcode[]['empCode'] = $bmtask['emp_code'];
        $staffname[]['staffName'] = $bmtask['staff_name'];
    }
    }
    //BM END//
    
}//designation //if condition END.
    
    for ($i=0; $i<count($dailyTasktitle); $i++) {    
    ?>      
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $empcode[$i]['empCode']; ?></td>
            <td><?php echo $staffname[$i]['staffName']; ?></td>
            <td><?php echo $dailyTaskWorkId[$i]['work_id']; ?></td>
            <td><?php echo $dailyTasktitle[$i]['title']; ?></td>
        </tr>
    
    <?php }  ?>
    </tbody>
</table>
<!-- Daily Task Table END -->

<!-- Task Table START -->
</br></br></br>
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
    <tbody>

<?php
$taskWorkId = array();
$tasktitle = array();
$fromdt = array();
$todt = array();
$empcode = array();
$staffname = array();
if($designation_id != '0'){

    $qry = "";

    $qry = "SELECT 'KRA & KPI' as work_id, DATE(kcr.from_date) as f_date, DATE(kcr.to_date) as t_date, CASE WHEN kcr.rr = 'New' THEN kcr.kpi ELSE rrr.rr END as title, sc.emp_code, sc.staff_name  
            FROM `krakpi_creation` kc 
            LEFT JOIN krakpi_creation_ref kcr ON kc.krakpi_id = kcr.krakpi_reff_id 
            LEFT JOIN rr_creation_ref rrr ON kcr.rr = rrr.rr_ref_id
            LEFT JOIN staff_creation sc ON kc.designation = sc.designation AND sc.status = 0
            WHERE kc.status = 0 
            AND kc.designation = '".$designation_id."' 
            AND 
            ( 
                YEAR(kcr.from_date) = YEAR(CURRENT_DATE)
                OR 
                YEAR(kcr.to_date) = YEAR(CURRENT_DATE)
            ) ";
    
    $krakpiInfo = $connect->query($qry);
    if($krakpiInfo){
        
    while ($krakpitask = $krakpiInfo->fetch()) { 
    
        $taskWorkId[]['work_id'] = $krakpitask['work_id'];
        $tasktitle[]['title'] = $krakpitask['title'];
        $fromdt[]['f_date'] = $krakpitask['f_date'];
        $todt[]['t_date'] = $krakpitask['t_date'];
        $empcode[]['empCode'] = $krakpitask['emp_code'];
        $staffname[]['staffName'] = $krakpitask['staff_name'];
        }
    }
    //KRAKPI END//
    
    //Audit start//
    $auditTaskInfo ="SELECT 'AUDIT ' as work_id, ac.audit_area as title, DATE(acr.from_date) as f_date, DATE(acr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM audit_area_creation_ref acr 
    LEFT JOIN audit_area_creation ac ON acr.audit_area_id = ac.audit_area_id 
    LEFT JOIN staff_creation sc1 ON ac.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON ac.role2 = sc2.designation AND sc2.status = 0
    WHERE ac.status = 0 AND (ac.role1 = '".$designation_id."' OR ac.role2 = '".$designation_id."') 
    AND 
    ( 
        YEAR(acr.from_date) = YEAR(CURRENT_DATE)
    OR
        YEAR(acr.to_date) = YEAR(CURRENT_DATE)
    )";
    
    $auditInfo = $connect->query($auditTaskInfo);
    if($auditInfo){
        
    while ($audittask = $auditInfo->fetch()) { 

        $taskWorkId[]['work_id'] = $audittask['work_id'];
        $tasktitle[]['title'] = $audittask['title'];
        $fromdt[]['f_date'] = $audittask['f_date'];
        $todt[]['t_date'] = $audittask['t_date'];
        $empcode[]['empCode'] = $audittask['emp_code'];
        $staffname[]['staffName'] = $audittask['staff_name'];
    }   
    } 
    //Audit END//
    
    //Maintance start//          
    $maintanceTaskInfo = "SELECT 'PM MAINTENANCE '  as work_id, pcr.checklist as title, DATE(pcr.from_date) as f_date, DATE(pcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM pm_checklist_ref pcr 
    LEFT JOIN maintenance_checklist mc ON pcr.maintenance_checklist_id = mc.maintenance_checklist_id 
    LEFT JOIN pm_checklist_multiple pcm ON pcr.pm_checklist_id = pcm.id 
    LEFT JOIN pm_checklist pc ON pcm.pm_checklist_id = pc.pm_checklist_id
    LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0 
    WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
    AND 
    ( 
        YEAR(pcr.from_date) = YEAR(CURRENT_DATE) 
    OR
        YEAR(pcr.to_date) = YEAR(CURRENT_DATE) 
    )";
    $maintanceInfo = $connect->query($maintanceTaskInfo);
    if($maintanceInfo){
    while ($maintancetask = $maintanceInfo->fetch()) { 

        $taskWorkId[]['work_id'] = $maintancetask['work_id'];
        $tasktitle[]['title'] = $maintancetask['title'];
        $fromdt[]['f_date'] = $maintancetask['f_date'];
        $todt[]['t_date'] = $maintancetask['t_date'];
        $empcode[]['empCode'] = $maintancetask['emp_code'];
        $staffname[]['staffName'] = $maintancetask['staff_name'];
    }
    } 
    //Maintance END//
    
    //BM Start//
    $bmTaskInfo = "SELECT 'BM MAINTENANCE ' as work_id, bcr.checklist as title, DATE(bcr.from_date) as f_date, DATE(bcr.to_date) as t_date, CONCAT(sc1.emp_code,' , ', sc2.emp_code) as emp_code, CONCAT(sc1.staff_name,' , ', sc2.staff_name) as staff_name 
    FROM bm_checklist_ref bcr 
    LEFT JOIN maintenance_checklist mc ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id 
    LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id 
    LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id
    LEFT JOIN staff_creation sc1 ON mc.role1 = sc1.designation AND sc1.status = 0 
    LEFT JOIN staff_creation sc2 ON mc.role2 = sc2.designation AND sc2.status = 0  
    WHERE mc.status = 0 AND (mc.role1 = '".$designation_id."' OR mc.role2 = '".$designation_id."')
    AND 
    ( 
        YEAR(bcr.from_date) = YEAR(CURRENT_DATE) 
    OR
        YEAR(bcr.to_date) = YEAR(CURRENT_DATE) 
    )";
    $bmInfo = $connect->query($bmTaskInfo);
    if($bmInfo){
    while ($bmtask = $bmInfo->fetch()) { 

        $taskWorkId[]['work_id'] = $bmtask['work_id'];
        $tasktitle[]['title'] = $bmtask['title'];
        $fromdt[]['f_date'] = $bmtask['f_date'];
        $todt[]['t_date'] = $bmtask['t_date'];
        $empcode[]['empCode'] = $bmtask['emp_code'];
        $staffname[]['staffName'] = $bmtask['staff_name'];
    }
    }
    //BM END//
    
    //campaign Start//
    $campaignTaskInfo = "SELECT 'CAMPAIGN ' as work_id, cf.activity_involved as title, DATE(cf.start_date) as f_date, DATE(cf.end_date) as t_date, sc.emp_code, sc.staff_name 
    FROM campaign_ref cf 
    LEFT JOIN campaign c ON cf.campaign_id = c.campaign_id
    LEFT JOIN staff_creation sc ON cf.employee_name = sc.staff_id AND sc.status = 0 
    WHERE c.status = 0 AND FIND_IN_SET('$staffid', employee_name) > 0 
    AND 
    ( 
        YEAR(cf.start_date) = YEAR(CURRENT_DATE)
    OR
        YEAR(cf.end_date) = YEAR(CURRENT_DATE)
    ) ";
    $campaignInfo = $con->query($campaignTaskInfo);
    if($campaignInfo){
    while($campaigntask = $campaignInfo->fetch_assoc()) {

        $taskWorkId[]['work_id'] = $campaigntask['work_id'];
        $tasktitle[]['title'] = $campaigntask['title'];
        $fromdt[]['f_date'] = $campaigntask['f_date'];
        $todt[]['t_date'] = $campaigntask['t_date'];
        $empcode[]['empCode'] = $campaigntask['emp_code'];
        $staffname[]['staffName'] = $campaigntask['staff_name'];
    }
    }
    //campaign END//
    
    //assign work list Start//
    $assignedTaskInfo = "SELECT 'ASSIGNED WORK ' as work_id, ref_id as id, work_status as sts, work_des_text as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name 
    FROM assign_work_ref awf 
    LEFT JOIN staff_creation sc ON awf.designation_id = sc.designation AND sc.status = 0 
    WHERE awf.status = 0 AND awf.designation_id = '".$designation_id."'
    AND 
        ( 
            YEAR(from_date) = YEAR(CURRENT_DATE) 
        OR
            YEAR(to_date) = YEAR(CURRENT_DATE) 
        )
        GROUP BY work_des_text "; 
    $assignInfo = $con->query($assignedTaskInfo);
    if($assignInfo){
    while($assignTask = $assignInfo->fetch_assoc()) { 

        $taskWorkId[]['work_id'] = $assignTask['work_id'];
        $tasktitle[]['title'] = $assignTask['title'];
        $fromdt[]['f_date'] = $assignTask['f_date'];
        $todt[]['t_date'] = $assignTask['t_date'];
        $empcode[]['empCode'] = $assignTask['emp_code'];
        $staffname[]['staffName'] = $assignTask['staff_name'];
    }
    }
    //assign work list END//
    
    //Todo Start //
    $todoqry = "SELECT 'TODO ' as work_id, work_des as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name
    FROM todo_creation tc
    LEFT JOIN staff_creation sc ON tc.assign_to = sc.staff_id AND sc.status = 0 
    WHERE tc.status = 0 AND FIND_IN_SET('$staffid', assign_to) > 0 AND 
    ( 
        YEAR(from_date) = YEAR(CURRENT_DATE) 
    OR
        YEAR(to_date) = YEAR(CURRENT_DATE) 
    )  ";
    $gettodoinfo = $con->query($todoqry);
    if($gettodoinfo){
    while($todoinfo = $gettodoinfo->fetch_assoc()){

        $taskWorkId[]['work_id'] = $todoinfo['work_id'];
        $tasktitle[]['title'] = $todoinfo['title'];
        $fromdt[]['f_date'] = $todoinfo['f_date'];
        $todt[]['t_date'] = $todoinfo['t_date'];
        $empcode[]['empCode'] = $todoinfo['emp_code'];
        $staffname[]['staffName'] = $todoinfo['staff_name'];
    }
    }
    //ToDo END //
    
    //Insurance Register Start //
    $insqry = "SELECT 'INSURANCE REGISTER ' as work_id, DATE(irr.from_date) as f_date, DATE(irr.to_date) as t_date,ir.insurance_id as ins_id, sc.emp_code, sc.staff_name
    FROM insurance_register_ref irr 
    LEFT JOIN insurance_register ir ON irr.ins_reg_id = ir.ins_reg_id
    LEFT JOIN staff_creation sc ON ir.designation_id = sc.designation AND sc.status = 0  
    WHERE ir.status = 0 
    AND ir.designation_id = '".$designation_id."' 
    AND 
    ( 
        YEAR(irr.from_date) = YEAR(CURRENT_DATE)
    OR
        YEAR(irr.to_date) = YEAR(CURRENT_DATE) 
    ) ";  
    
    $insdeatils = $con->query($insqry);
    if($insdeatils){
    while($insInfo = $insdeatils->fetch_assoc()){
        $inscreation = $con->query("SELECT insurance_name FROM insurance_creation WHERE status = 0 AND insurance_id = '". $insInfo["ins_id"]."' ");
        $inscrtion = $inscreation->fetch_assoc();
            $insurance_name = $inscrtion["insurance_name"];

        $taskWorkId[]['work_id'] = $insInfo['work_id'];
        $tasktitle[]['title'] = $insurance_name;
        $fromdt[]['f_date'] = $insInfo['f_date'];
        $todt[]['t_date'] = $insInfo['t_date'];
        $empcode[]['empCode'] = $insInfo['emp_code'];
        $staffname[]['staffName'] = $insInfo['staff_name'];
    }
    }
    //Insurance Register END //
    
    //FC Ins Start //
    $fc_ins_details = $con->query("SELECT 'FC INSURANCE RENEWAL ' as work_id, fc_insurance_renew_id as id, work_status as sts, assign_remark as title, DATE(from_date) as f_date, DATE(to_date) as t_date, sc.emp_code, sc.staff_name 
    FROM fc_insurance_renew fir
    LEFT JOIN staff_creation sc ON fir.assign_staff_name = sc.staff_id AND sc.status = 0  
    WHERE fir.status = 0 AND FIND_IN_SET('$staffid', assign_staff_name) > 0  
    AND 
    ( 
        YEAR(from_date) = YEAR(CURRENT_DATE)
    OR
        YEAR(to_date) = YEAR(CURRENT_DATE)
    ) ");
    while($fcInfo = $fc_ins_details->fetch_assoc()){
        
        $taskWorkId[]['work_id'] = $fcInfo['work_id'];
        $tasktitle[]['title'] = $fcInfo['title'];
        $fromdt[]['f_date'] = $fcInfo['f_date'];
        $todt[]['t_date'] = $fcInfo['t_date'];
        $empcode[]['empCode'] = $fcInfo['emp_code'];
        $staffname[]['staffName'] = $fcInfo['staff_name'];
    }
    //FC Ins END //
    
}//designation //if condition END.
    
    for ($i=0; $i<count($tasktitle); $i++) {    
    ?>      
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $empcode[$i]['empCode']; ?></td>
            <td><?php echo $staffname[$i]['staffName']; ?></td>
            <td><?php echo $taskWorkId[$i]['work_id']; ?></td>
            <td><?php echo $tasktitle[$i]['title']; ?></td>
            <td><?php echo $fromdt[$i]['f_date']; ?></td>
            <td><?php echo $todt[$i]['t_date']; ?></td>
        </tr>
    
    <?php }  ?>
    </tbody>
</table>
<!-- Task Table END -->


<script type="text/javascript">
    $(function() {
        $('#reponsibility_report_data').DataTable({
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
                        columns: [ 0, 1, 2, 3 ]
                    }
                }
            ],
        });

        $('#dailytask_data').DataTable({
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
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                }
            ],
        });

        $('#task_data').DataTable({
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6 ]
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

            if(tableId == 'reponsibility_report_data'){
                title = 'Responsibility Report';

            }else if(tableId == 'dailytask_data'){
                title = 'Daily Task';
                
            }else if(tableId == 'task_data'){
                title = 'Task';
                
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