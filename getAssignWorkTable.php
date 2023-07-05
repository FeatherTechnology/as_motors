<?php 
include('ajaxconfig.php');
@session_start();
date_default_timezone_set('Asia/Calcutta');
$current_date = date('m');

if(isset($_SESSION["staffid"])){
    $staff_id = $_SESSION["staffid"];
}else{
    $staff_id = 0;
}

$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
$res9 = $con->query($getqry9);
$holiday_dates = [];
while ($row9 = $res9->fetch_assoc()) {
    $holiday_dates[] = $row9["holiday_date"];
}

$detailRecords = array();
$designation = '';
// get staff designation based on session staff id
$getDesignation = "SELECT designation FROM staff_creation WHERE staff_id = '".$staff_id."' ";
$runQry = $con->query($getDesignation);
while($row5 = $runQry->fetch_assoc()){
    $designation = $row5['designation'];
}

$today = date('Y-m-d');
// get assign work list and to_date > '".$today."'
$getqry = "SELECT * FROM assign_work_ref WHERE status = 0 AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(from_date) AND MONTH(to_date)) OR work_status IN (0, 1, 2)) AND designation_id = '".$designation."' order by priority desc "; 
$res = $con->query($getqry);
$i=0;
while($row = $res->fetch_assoc())
{
    $detailRecords[$i]['work_id'] = $row["ref_id"];      
    $detailRecords[$i]['department_id'] = $row["department_id"];      
    $detailRecords[$i]['work_des'] = $row["work_des"];      
    $detailRecords[$i]['work_des_text'] = $row["work_des_text"];      
    $detailRecords[$i]['designation_id'] = $row["designation_id"];      
    $detailRecords[$i]['priority'] = $row["priority"];        
    $detailRecords[$i]['from_date'] = $row["from_date"];      
    $detailRecords[$i]['to_date'] = $row["to_date"];  
    $detailRecords[$i]['assign_work_sts'] = $row["work_status"];    
    
    $work_status1 = $row["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['work_status'] = $work_status;
    $i++;
}

// get Todo list
$getqry1 = "SELECT * FROM todo_creation WHERE status = 0 AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN month(from_date) AND month(to_date)) OR work_status IN (0, 1, 2)) AND FIND_IN_SET('$staff_id', assign_to) > 0 order by priority desc ";
$res1 = $con->query($getqry1);
$i=0;
while($row1 = $res1->fetch_assoc())
{
    $detailRecords[$i]['todo_id'] = $row1["todo_id"];      
    $detailRecords[$i]['todo_company_id'] = $row1["company_id"];      
    $detailRecords[$i]['todo_work_des'] = $row1["work_des"];      
    $detailRecords[$i]['todo_tag_id'] = $row1["tag_id"];      
    $detailRecords[$i]['todo_priority'] = $row1["priority"];      
    $detailRecords[$i]['todo_assign_to'] = $row1["assign_to"];      
    $detailRecords[$i]['todo_from_date'] = $row1["from_date"];      
    $detailRecords[$i]['todo_to_date'] = $row1["to_date"];  
    $detailRecords[$i]['todo_work_sts'] = $row1["work_status"];  
    
    $work_status1 = $row1["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['todo_work_status'] = $work_status;   
    $i++;
}

// get KRA & KPI list
$getqry2 = "SELECT krakpi_calendar_map.krakpi_calendar_map_id, krakpi_calendar_map.krakpi_ref_id, krakpi_calendar_map.kra_category, krakpi_calendar_map.from_date, 
krakpi_calendar_map.to_date, krakpi_calendar_map.work_status 
FROM krakpi_calendar_map LEFT JOIN krakpi_creation ON krakpi_calendar_map.krakpi_id = krakpi_creation.krakpi_id LEFT JOIN krakpi_creation_ref ON krakpi_calendar_map.krakpi_ref_id = krakpi_creation_ref.krakpi_ref_id WHERE krakpi_creation.status = 0 AND krakpi_creation_ref.frequency != 'Daily Task' AND krakpi_creation.designation = '".$designation."' AND krakpi_calendar_map.calendar = 'Yes' AND ((krakpi_calendar_map.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(krakpi_calendar_map.from_date) AND MONTH(krakpi_calendar_map.to_date)) OR krakpi_calendar_map.work_status IN (0, 1, 2)) ";
$res2 = $con->query($getqry2);
$i=0;
while($row2 = $res2->fetch_assoc())
{
    $detailRecords[$i]['krakpi_calendar_map_id'] = $row2["krakpi_calendar_map_id"];          
    $getqry3 = "SELECT rr,kpi FROM krakpi_creation_ref WHERE status = 0 AND krakpi_ref_id = '".$row2["krakpi_ref_id"]."' ";
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc()){ 
        $rr = $row3["rr"];
        $kpi = $row3["kpi"];
    }
    if($rr == 'New'){
        $detailRecords[$i]['krakpi_rr'] = $kpi; 
    }else{
        $getqry3 = "SELECT rr FROM rr_creation_ref WHERE status = 0 AND rr_ref_id = '".$rr."' ";
        $res3 = $con->query($getqry3);
        $row3 = $res3->fetch_assoc();
            $detailRecords[$i]['krakpi_rr'] = $row3["rr"];
    }           

    $checkFromDate = date('m', strtotime($row2["from_date"]));
    $checkToDate = date('m', strtotime($row2["to_date"]));

    // if ($checkFromDate == $current_date) {  // To show Current month only not future month. 

        $detailRecords[$i]['krakpi_calendar_map_from_date'] = $row2["from_date"];      
        $detailRecords[$i]['krakpi_calendar_map_to_date'] = $row2["to_date"];   
    // }
    $detailRecords[$i]['krakpi_calendar_work_sts'] = $row2["work_status"]; 
    $work_status1 = $row2["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['krakpi_calendar_map_work_status'] = $work_status;   
    $i++;
}

// get audit area creation list
$getqry4 = "SELECT audit_area_creation_ref.audit_area_creation_ref_id, audit_area_creation_ref.audit_area_id, audit_area_creation_ref.from_date, 
audit_area_creation_ref.to_date, audit_area_creation_ref.work_status, audit_area_creation.audit_area  
FROM audit_area_creation_ref LEFT JOIN audit_area_creation  ON audit_area_creation_ref.audit_area_id = audit_area_creation.audit_area_id WHERE audit_area_creation.status = 0 AND audit_area_creation.frequency != 'Daily Task' AND ((audit_area_creation_ref.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(audit_area_creation_ref.from_date) AND MONTH(audit_area_creation_ref.to_date)) OR audit_area_creation_ref.work_status IN (0, 1, 2)) AND audit_area_creation.calendar = 'Yes' AND (audit_area_creation.role1 = '".$designation."' 
OR audit_area_creation.role2 = '".$designation."') "; 
$res4 = $con->query($getqry4);
$i=0;
while($row4 = $res4->fetch_assoc())
{
    $detailRecords[$i]['audit_area_creation_ref_id'] = $row4["audit_area_creation_ref_id"];      
    $detailRecords[$i]['audit_area'] = $row4["audit_area"];    
    
    $checkFromDate = date('m', strtotime($row4["from_date"]));
    $checkToDate = date('m', strtotime($row4["to_date"]));

    // if ($checkFromDate == $current_date) {
    
        $detailRecords[$i]['audit_from_date'] = $row4["from_date"];      
        $detailRecords[$i]['audit_to_date'] = $row4["to_date"];          
    // }
    $detailRecords[$i]['audit_work_sts'] = $row4["work_status"]; 
    $work_status1 = $row4["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['audit_work_status'] = $work_status;   
    $i++;
}

// get maintenance checklist list - PM
$getqry5 = "SELECT pm_checklist_ref.pm_checklist_ref_id, pm_checklist_ref.maintenance_checklist_id,  pm_checklist_ref.pm_checklist_id, pm_checklist_ref.checklist, 
pm_checklist_ref.from_date, pm_checklist_ref.to_date, pm_checklist_ref.work_status FROM pm_checklist_ref LEFT JOIN maintenance_checklist 
ON pm_checklist_ref.maintenance_checklist_id = maintenance_checklist.maintenance_checklist_id LEFT JOIN pm_checklist_multiple ON pm_checklist_ref.pm_checklist_id = pm_checklist_multiple.id LEFT JOIN pm_checklist ON pm_checklist_multiple.pm_checklist_id = pm_checklist.pm_checklist_id WHERE maintenance_checklist.status = 0 AND pm_checklist.frequency != 'Daily Task'
AND ((pm_checklist_ref.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(pm_checklist_ref.from_date) AND MONTH(pm_checklist_ref.to_date)) OR pm_checklist_ref.work_status IN (0, 1, 2)) AND maintenance_checklist.calendar = 'Yes' AND (maintenance_checklist.role1 = '".$designation."' 
OR maintenance_checklist.role2 = '".$designation."') "; 
$res5 = $con->query($getqry5);
$i=0;
while($row5 = $res5->fetch_assoc())
{
    $detailRecords[$i]['maintenance_checklist_ref_id'] = $row5["pm_checklist_ref_id"];
    $detailRecords[$i]['maintenance_checklist_ref_checklist'] = $row5["checklist"];

    $checkFromDate = date('m', strtotime($row5["from_date"]));
    $checkToDate = date('m', strtotime($row5["to_date"]));

    // if ($checkFromDate == $current_date) {

        $detailRecords[$i]['maintenance_checklist_ref_from_date'] = $row5["from_date"];      
        $detailRecords[$i]['maintenance_checklist_ref_to_date'] = $row5["to_date"];  
    // }        
    $detailRecords[$i]['maintance_work_sts'] = $row5["work_status"]; 
    $work_status1 = $row5["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['maintenance_checklist_ref_work_status'] = $work_status;   
    $i++;
}

// get maintenance checklist list -BM
$getqry8 = "SELECT bcr.bm_checklist_ref_id, bcr.maintenance_checklist_id,  bcr.bm_checklist_id, bcr.checklist, 
bcr.from_date, bcr.to_date, bcr.work_status FROM bm_checklist_ref bcr LEFT JOIN maintenance_checklist mc 
ON bcr.maintenance_checklist_id = mc.maintenance_checklist_id LEFT JOIN bm_checklist_multiple bcm ON bcr.bm_checklist_id = bcm.id LEFT JOIN bm_checklist bc ON bcm.bm_checklist_id = bc.bm_checklist_id  WHERE mc.status = 0 AND bc.frequency != 'Daily Task' AND ((bcr.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(bcr.from_date) AND MONTH(bcr.to_date)) OR bcr.work_status IN (0, 1, 2)) AND mc.calendar = 'Yes' AND (mc.role1 = '".$designation."' OR mc.role2 = '".$designation."') "; 
$res8 = $con->query($getqry8);
$i=0;
while($row8 = $res8->fetch_assoc())
{
    $detailRecords[$i]['maintenance_checklist_ref_id_bm'] = $row8["bm_checklist_ref_id"];
    $detailRecords[$i]['maintenance_checklist_ref_checklist_bm'] = $row8["checklist"];

    $checkFromDate = date('m', strtotime($row8["from_date"]));
    $checkToDate = date('m', strtotime($row8["to_date"]));

    // if ($checkFromDate == $current_date) {

        $detailRecords[$i]['maintenance_checklist_ref_from_date_bm'] = $row8["from_date"];      
        $detailRecords[$i]['maintenance_checklist_ref_to_date_bm'] = $row8["to_date"];  
    // }        
    $detailRecords[$i]['maintance_work_sts_bm'] = $row8["work_status"]; 
    $work_status1 = $row8["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['maintenance_checklist_ref_work_status_bm'] = $work_status;   
    $i++;
}

// get campaign ref list
$getqry6 = "SELECT campaign_ref.campaign_ref_id, campaign_ref.campaign_id, campaign_ref.promotional_activities_ref_id, campaign_ref.activity_involved, 
campaign_ref.start_date, campaign_ref.end_date, campaign_ref.work_status FROM campaign_ref LEFT JOIN campaign ON campaign_ref.campaign_id = campaign.campaign_id 
WHERE campaign.status = 0 AND ((campaign_ref.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(campaign_ref.start_date) AND MONTH(campaign_ref.end_date)) OR campaign_ref.work_status IN (0, 1, 2)) AND FIND_IN_SET('$staff_id', employee_name) > 0 ";
$res6 = $con->query($getqry6);
$i=0;
while($row6 = $res6->fetch_assoc())
{
    $detailRecords[$i]['campaign_ref_id'] = $row6["campaign_ref_id"];      
    $detailRecords[$i]['campaign_id'] = $row6["campaign_id"];      
    $detailRecords[$i]['promotional_activities_ref_id'] = $row6["promotional_activities_ref_id"];          
    $detailRecords[$i]['activity_involved'] = $row6["activity_involved"];          
    $detailRecords[$i]['campaign_start_date'] = $row6["start_date"];          
    $detailRecords[$i]['campaign_end_date'] = $row6["end_date"];          
    $detailRecords[$i]['campaign_work_sts'] = $row6["work_status"]; 
    $work_status1 = $row6["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['campaign_work_status'] = $work_status;   
    $i++;
}

// get insurance register
$getqry7 = "SELECT insurance_register_ref.ins_reg_ref_id, insurance_register_ref.ins_reg_id, insurance_register.insurance_id, insurance_register_ref.from_date, 
insurance_register_ref.to_date, insurance_register_ref.work_status 
FROM insurance_register_ref LEFT JOIN insurance_register 
ON insurance_register_ref.ins_reg_id = insurance_register.ins_reg_id 
WHERE insurance_register.status = 0 
AND (
    (insurance_register_ref.work_status = 3 AND MONTH(CURDATE()) BETWEEN MONTH(insurance_register_ref.from_date) AND MONTH(insurance_register_ref.to_date)) OR insurance_register_ref.work_status IN (0, 1, 2)
    ) 
AND (
        insurance_register_ref.to_date >= CURDATE()
        AND 
        insurance_register_ref.to_date <= CURDATE() + INTERVAL 30 DAY
    ) 
AND  insurance_register.designation_id = '".$designation."' ";  
$res7 = $con->query($getqry7);
$i=0;
while($row7 = $res7->fetch_assoc())
{
    $detailRecords[$i]['ins_reg_ref_id'] = $row7["ins_reg_ref_id"]; 
    $getqry8 = "SELECT insurance_name FROM insurance_creation WHERE status = 0 AND insurance_id = '". $row7["insurance_id"]."' ";
    $res8 = $con->query($getqry8);
    while($row8 = $res8->fetch_assoc()){
        $detailRecords[$i]['insurance_name'] = $row8["insurance_name"];   
    }

    $checkFromDate = date('m', strtotime($row7["from_date"]));
    $checkToDate = date('m', strtotime($row7["to_date"]));

    // if ($checkFromDate == $current_date) {

        $detailRecords[$i]['insurance_from_date'] = $row7["from_date"];
        $detailRecords[$i]['insurance_to_date'] = $row7["to_date"];
    // }
    $detailRecords[$i]['insurance_work_sts'] = $row7["work_status"]; 
    $work_status1 = $row7["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['insurance_work_status'] = $work_status;   
    $i++;
}

// get Todo list
$getqry1 = "SELECT * FROM fc_insurance_renew WHERE status = 0 AND ((work_status = 3 AND MONTH(CURDATE()) BETWEEN month(from_date) AND month(to_date)) OR work_status IN (0, 1, 2)) AND FIND_IN_SET('$staff_id', assign_staff_name) > 0  ";
$res1 = $con->query($getqry1);
$i=0;
while($row1 = $res1->fetch_assoc())
{
    $detailRecords[$i]['Fc_insurance_renew_id'] = $row1["fc_insurance_renew_id"];      
    $detailRecords[$i]['Fc_branch_id'] = $row1["branch_id"];      
    $detailRecords[$i]['Fc_assign_remark'] = $row1["assign_remark"];     
    $detailRecords[$i]['Fc_assign_to'] = $row1["assign_staff_name"];      
    $detailRecords[$i]['Fc_from_date'] = $row1["from_date"];      
    $detailRecords[$i]['Fc_to_date'] = $row1["to_date"];  
    $detailRecords[$i]['Fc_work_sts'] = $row1["work_status"];  
    
    $work_status1 = $row1["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    if ($work_status1 == 3) {$work_status = 'Completed';}
    $detailRecords[$i]['Fc_work_status'] = $work_status;   
    $i++;
}


echo json_encode($detailRecords);
?>