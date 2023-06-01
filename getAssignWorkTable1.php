<?php 
include('ajaxconfig.php');
@session_start();
date_default_timezone_set('Asia/Calcutta');

if(isset($_SESSION["staffid"])){
    $staff_id = $_SESSION["staffid"];
}else{
    $staff_id = 0;
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
$getqry = "SELECT * FROM assign_work_ref WHERE status = 0 and work_status != 3 AND designation_id = '".$designation."' order by priority desc "; 
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
    
    $work_status1 = $row["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['work_status'] = $work_status;
    $i++;
}

// get Todo list
$getqry1 = "SELECT * FROM todo_creation WHERE status = 0 and work_status != 3 AND FIND_IN_SET($staff_id, assign_to) > 0 order by priority desc ";
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
    
    $work_status1 = $row1["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['todo_work_status'] = $work_status;   
    $i++;
}

// get KRA & KPI list
$getqry2 = "SELECT krakpi_id, company_name, department, designation, krakpi_ref_id, kra_category, rr, kpi, frequency, from_date, to_date, work_status 
FROM krakpi_creation_ref LEFT JOIN krakpi_creation ON krakpi_creation_ref.krakpi_reff_id = krakpi_creation.krakpi_id WHERE krakpi_creation.status = 0 
AND krakpi_creation.designation = '".$designation."' AND krakpi_creation_ref.work_status != 3 AND krakpi_creation_ref.calendar = 'Yes' ";
$res2 = $con->query($getqry2);
$i=0;
while($row2 = $res2->fetch_assoc())
{
    $detailRecords[$i]['krakpi_id'] = $row2["krakpi_id"];          
    $detailRecords[$i]['krakpi_designation'] = $row2["designation"];        
    $detailRecords[$i]['krakpi_ref_id'] = $row2["krakpi_ref_id"];        
    $rr = $row2["rr"];
    if($rr == 'New'){
        $detailRecords[$i]['krakpi_rr'] = $row2["kpi"]; 
    }else{
        $getqry3 = "SELECT rr FROM rr_creation_ref WHERE status = 0 AND rr_ref_id = '".$rr."' ";
        $res3 = $con->query($getqry3);
        while($row3 = $res3->fetch_assoc()){
            $detailRecords[$i]['krakpi_rr'] = $row3["rr"];   
        }
    }           
    $detailRecords[$i]['krakpi_from_date'] = $row2["from_date"];      
    $detailRecords[$i]['krakpi_to_date'] = $row2["to_date"];   
    
    $work_status1 = $row2["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['krakpi_work_status'] = $work_status;   
    $i++;
}

// get audit area creation list
$getqry4 = "SELECT * FROM audit_area_creation WHERE status = 0 and work_status != 3  AND calendar = 'Yes' AND (role1 = '".$designation."' OR role2 = '".$designation."') "; 
$res4 = $con->query($getqry4);
$i=0;
while($row4 = $res4->fetch_assoc())
{
    $detailRecords[$i]['audit_area_id'] = $row4["audit_area_id"];      
    $detailRecords[$i]['audit_area'] = $row4["audit_area"];      
    $detailRecords[$i]['audit_from_date'] = $row4["from_date"];      
    $detailRecords[$i]['audit_to_date'] = $row4["to_date"];          
    
    $work_status1 = $row4["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['audit_work_status'] = $work_status;   
    $i++;
}

// get maintenance checklist list
$getqry5 = "SELECT * FROM maintenance_checklist WHERE status = 0 and work_status != 3 AND calendar = 'Yes' AND (role1 = '".$designation."' OR role2 = '".$designation."') "; 
$res5 = $con->query($getqry5);
$i=0;
while($row5 = $res5->fetch_assoc())
{
    $detailRecords[$i]['maintenance_checklist_id'] = $row5["maintenance_checklist_id"];      
    $getqry6 = "SELECT asset_name FROM asset_register WHERE status = 0 AND asset_id = '". $row5["asset_details"]."' ";
    $res6 = $con->query($getqry6);
    while($row6 = $res6->fetch_assoc()){
        $detailRecords[$i]['maintenance_asset_details'] = $row6["asset_name"];   
    }
    $detailRecords[$i]['maintenance_from_date'] = $row5["from_date"];      
    $detailRecords[$i]['maintenance_to_date'] = $row5["to_date"];          
    
    $work_status1 = $row5["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['maintenance_work_status'] = $work_status;   
    $i++;
}

// get campaign ref list
$getqry6 = "SELECT campaign_ref.campaign_ref_id, campaign_ref.campaign_id, campaign_ref.promotional_activities_ref_id, campaign_ref.activity_involved, 
campaign_ref.start_date, campaign_ref.end_date, campaign_ref.work_status FROM campaign_ref LEFT JOIN campaign ON campaign_ref.campaign_id = campaign.campaign_id 
WHERE campaign.status = 0 AND campaign_ref.work_status != 3 AND FIND_IN_SET($staff_id, employee_name) > 0 ";
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
    
    $work_status1 = $row6["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['campaign_work_status'] = $work_status;   
    $i++;
}


// get insurance register
$getqry7 = "SELECT * FROM insurance_register WHERE status = 0 and work_status != 3 AND calendar = 'Yes' AND staff_id = '".$staff_id."' "; 
$res7 = $con->query($getqry7);
$i=0;
while($row7 = $res7->fetch_assoc())
{
    $detailRecords[$i]['ins_reg_id'] = $row7["ins_reg_id"];      
    $getqry6 = "SELECT insurance_name FROM insurance_creation WHERE status = 0 AND insurance_id = '". $row7["insurance_id"]."' ";
    $res6 = $con->query($getqry6);
    while($row6 = $res6->fetch_assoc()){
        $detailRecords[$i]['insurance_name'] = $row6["insurance_name"];   
    }
    $detailRecords[$i]['insurance_from_date'] = $row7["from_date"];      
    $detailRecords[$i]['insurance_to_date'] = $row7["to_date"];          
    
    $work_status1 = $row7["work_status"];
    if ($work_status1 == 0) {$work_status = '';}
    if ($work_status1 == 1) {$work_status = 'In Progress';}
    if ($work_status1 == 2) {$work_status = 'Pending';}
    $detailRecords[$i]['insurance_work_status'] = $work_status;   
    $i++;
}

echo json_encode($detailRecords);
?>