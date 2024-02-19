<?php
include '../ajaxconfig.php';
@session_start();
date_default_timezone_set('Asia/Calcutta');
$current_time = date('H:i:s');
$current_date = date('Y-m-d');

if(isset($_POST['company_id'])){
    $company_id = $_POST['company_id'];
}
if(isset($_POST['doi'])){
    $doi = $_POST['doi'];
}
if(isset($_POST['asset_details'])){
    $asset_details = $_POST['asset_details'];
}
if(isset($_POST['checklist'])){
    $checklist = $_POST['checklist'];
}
if(isset($_POST['calendar'])){
    $calendar = $_POST['calendar'];
}
if(isset($_POST['from_date'])){
    $from_date1 = $_POST['from_date'];
}
if(isset($_POST['to_date'])){
    $to_date1 = $_POST['to_date'];
}
if(isset($_POST['role1'])){
    $role1 = $_POST['role1'];
}
if(isset($_POST['role2'])){
    $role2 = $_POST['role2'];
}
if(isset($_POST['checkedid'])){
    $checkedid = $_POST['checkedid'];
    $checkedidStr = implode(',', $checkedid);
}
if(isset($_POST['remarks'])){
    $remarks = $_POST['remarks'];
    $remarksStr = implode(',', $remarks);
}
if(isset($_POST['maintenanceChceklistId'])){
    $maintenanceChceklistId = $_POST['maintenanceChceklistId'];
} 
if(isset($_POST['maintenanceChceklistRefId'])){
    $maintenanceChceklistRefId = $_POST['maintenanceChceklistRefId'];
    $maintenanceChceklistRefIdStr = implode(',', $maintenanceChceklistRefId);
}
if(isset($_POST['frequency'])){
    $frequency = $_POST['frequency'];
    $frequencyStr = implode(',', $frequency);
}
if(isset($_POST['frequency_applicable'])){
    $frequency_applicable = $_POST['frequency_applicable']; 
    $frequency_applicableStr = implode(',', $frequency_applicable);
}
if(isset($_POST['checkListId'])){ // pm_checklist Table id.
    $checkListId = $_POST['checkListId']; 
    print_r($checkListId);
    $checkListIdStr = implode(',', $checkListId);
}
if(isset($_POST['checklist_textarea'])){
    $checklist_textarea = $_POST['checklist_textarea'];
    $checklist_textareaStr = implode(',', $checklist_textarea);
}

if($calendar == "No"){
    $from_date = '';
    $to_date = '';
} else {
    $from_date = $from_date1.' '.$current_time;
    $to_date = $to_date1.' '.$current_time;
}

if(isset($_FILES['file'])){ 
    $files = $_FILES['file']; 
    foreach ($files['name'] as $index => $name) { 
        $file[] = $files['name'][$index];
        $file_name = $files['name'][$index];
        $checklistfile_tmp = $files['tmp_name'][$index];
        $maintenanceChecklistfilefolder="../uploads/maintenance_checklist/".$file_name;
        move_uploaded_file($checklistfile_tmp, $maintenanceChecklistfilefolder);
    }
}else{
    $file=[];
}

$checkListIdArr = array_map('intval', explode(',', $checkListIdStr));  //pm_checklist table id.
$checkedidArr = array_map('intval', explode(',', $checkedidStr));  //pm_checklist_multiple table id.
$remarksArr = array_map('strval', explode(',', $remarksStr)); 
$maintenanceChceklistRefIdArr = array_map('strval', explode(',', $maintenanceChceklistRefIdStr));
$frequencyArr = array_map('strval', explode(',', $frequencyStr)); 
$frequency_applicableArr = array_map('strval', explode(',', $frequency_applicableStr)); 
$checklist_textareaArr = array_map('strval', explode(',', $checklist_textareaStr)); 
$frqArr = array('Yearly', 'Daily Task');

// select holiday
$getqry9 = "SELECT holiday_date FROM holiday_creation_ref WHERE 1";
$res9 = $mysqli->query($getqry9);
$holiday_dates = [];
while ($row9 = $res9->fetch_assoc()) {
    $holiday_dates[] = $row9["holiday_date"];
}

if($checklist == 'pm_checklist'){ 
    // update
    $updateQry = 'UPDATE maintenance_checklist SET company_id = "'.strip_tags($company_id).'", date_of_inspection = "'.strip_tags($doi).'", 
    role1 = "'.strip_tags($role1).'",asset_details = "'.strip_tags($asset_details).'",checklist = "'.strip_tags($checklist).'",
    role2 = "'.strip_tags($role2).'", calendar = "'.strip_tags($calendar).'", from_date = "'.strip_tags($from_date).'", to_date = "'.strip_tags($to_date).'", 
    status = "0" WHERE maintenance_checklist_id = "'.mysqli_real_escape_string($mysqli, $maintenanceChceklistId).'" ';
    $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

    // delete maintenance checklist ref
    $deleteChecklistRef = $mysqli->query("DELETE FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".$maintenanceChceklistId."' "); 

    // delete pm checklist ref
    $deleteChecklistRef = $mysqli->query("DELETE FROM pm_checklist_ref WHERE maintenance_checklist_id = '".$maintenanceChceklistId."' "); 

    // insert
    for($i=0; $i<=sizeof($checkedidArr)-1; $i++){ 

        $insertChecklistRef = "INSERT INTO maintenance_checklist_ref(maintenance_checklist_id, pm_checklist_id, remarks, file)
        VALUES ('".strip_tags($maintenanceChceklistId)."', '".strip_tags($checkedidArr[$i])."', '".strip_tags($remarksArr[$i])."', '".strip_tags($file[$i])."')"; 
        $insertChecklistRefRun = $con->query($insertChecklistRef);
        $checklistRefId = $con->insert_id;

        if($frequency_applicableArr[$i] == 'frequency_applicable' && $calendar == "Yes" && !in_array($frequencyArr[$i], $frqArr)){ 

            if($frequencyArr[$i] == 'Weekly'){
    
                $end_of_year = date('Y-12-31');
                $current_from_date = date('Y-m-d', strtotime($from_date1));
                $current_to_date = date('Y-m-d', strtotime($to_date1));
            
                $from_dates = array();
                $to_dates = array();
            
                while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                    // Check if current_from_date is a Sunday or holiday
                    while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                        $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                    }
                    
                    // Check if current_to_date is a Sunday or holiday
                    while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                        $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                    }
                
                    if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                    $to_dates[] = $current_to_date;
                    }

                    $current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
                    $current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
                
                    if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                        break;
                    }
                }
            } 
            if($frequencyArr[$i] == 'Fortnightly'){
    
                $end_of_year = date('Y-12-31');
                $current_from_date = date('Y-m-d', strtotime($from_date1));
                $current_to_date = date('Y-m-d', strtotime($to_date1));
            
                $from_dates = array();
                $to_dates = array();
            
                while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                    // Check if current_from_date is a Sunday or holiday
                    while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                        $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                    }
                    
                    // Check if current_to_date is a Sunday or holiday
                    while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                        $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                    }
                
                    if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                    $to_dates[] = $current_to_date;
                    }

                    $current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
                    $current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
                
                    if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                        break;
                    }
                }
            } 

            if($frequencyArr[$i] == 'Monthly'){
    
                $end_of_year = date('Y-12-31');
                $current_from_date = date('Y-m-d', strtotime($from_date1));
                $current_to_date = date('Y-m-d', strtotime($to_date1));
            
                $from_dates = array();
                $to_dates = array();
            
                while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                    // Check if current_from_date is a Sunday or holiday
                    while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                        $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                    }
                    
                    // Check if current_to_date is a Sunday or holiday
                    while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                        $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                    }

                    if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                    $to_dates[] = $current_to_date;
                    }

                    $current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
                    $current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
                
                    if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                        break;
                    }
                }
            } 

            if($frequencyArr[$i] == 'Quaterly'){ 
    
                $end_of_year = date('Y-12-31');
                $current_from_date = date('Y-m-d', strtotime($from_date1));
                $current_to_date = date('Y-m-d', strtotime($to_date1));
            
                $from_dates = array();
                $to_dates = array();
            
                while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                    // Check if current_from_date is a Sunday or holiday
                    while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                        $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                    }
                    
                    // Check if current_to_date is a Sunday or holiday
                    while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                        $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                    }
                
                    if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                    $to_dates[] = $current_to_date;
                    }

                    $current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
                    $current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
                
                    if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                        break;
                    }
                }
            } 

            if($frequencyArr[$i] == 'Half Yearly'){ 
    
                $end_of_year = date('Y-12-31');
                $current_from_date = date('Y-m-d', strtotime($from_date1));
                $current_to_date = date('Y-m-d', strtotime($to_date1));
            
                $from_dates = array();
                $to_dates = array();
            
                while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                    // Check if current_from_date is a Sunday or holiday
                    while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                        $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                    }
                    
                    // Check if current_to_date is a Sunday or holiday
                    while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                        $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                    }
                
                    if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                    $to_dates[] = $current_to_date;
                    }

                    $current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
                    $current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
                
                    if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                        break;
                    }
                }
            } 

            for($j=0; $j<=sizeof($from_dates)-1; $j++){ 

                $insertQry="INSERT INTO pm_checklist_ref(pm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
                role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($checklistRefId)."', 
                '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', '".strip_tags($to_dates[$j].' '.$current_time)."', 
                '".strip_tags($role1)."', '".strip_tags($role2)."' )";
                $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
            } 
            
        } else if ($frequencyArr[$i] == 'Daily Task' && $calendar == "No"){
            //if select Daily Task in frequency then insert record per day for current year. 
            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($current_date));
        
            $from_dates = array();
        
            while ($current_from_date <= $end_of_year ) {
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }

                if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                    $from_dates[] = $current_from_date;
                }

                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
            
                if ($current_from_date > $end_of_year ) {
                    break;
                }
            }//While END.

            for($a=0; $a <count($from_dates); $a++){

                $insertQry="INSERT INTO pm_checklist_ref(pm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
                role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($checklistRefId)."', 
                '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_dates[$a].' '.$current_time)."', '".strip_tags($from_dates[$a].' '.$current_time)."', 
                '".strip_tags($role1)."', '".strip_tags($role2)."' )";
                $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
            } 

        } else { 
    
            $insertQry="INSERT INTO pm_checklist_ref(pm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
            role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($checklistRefId)."', 
            '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($role1)."', '".strip_tags($role2)."' )";
            $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
        }
    }

}else if($checklist == 'bm_checklist'){
   // update
    $updateQry = 'UPDATE maintenance_checklist SET company_id = "'.strip_tags($company_id).'", date_of_inspection = "'.strip_tags($doi).'", 
    role1 = "'.strip_tags($role1).'",asset_details = "'.strip_tags($asset_details).'",checklist = "'.strip_tags($checklist).'",
    role2 = "'.strip_tags($role2).'", calendar = "'.strip_tags($calendar).'", from_date = "'.strip_tags($from_date).'", to_date = "'.strip_tags($to_date).'", 
    status = "0" WHERE maintenance_checklist_id = "'.mysqli_real_escape_string($mysqli, $maintenanceChceklistId).'" ';
    $res = $mysqli->query($updateQry) or die ("Error in in update Query!.".$mysqli->error); 

    // delete
    $deleteChecklistRef = $mysqli->query("DELETE FROM maintenance_checklist_ref WHERE maintenance_checklist_id = '".$maintenanceChceklistId."' "); 

    // delete bm checklist ref
    $deleteChecklistRef = $mysqli->query("DELETE FROM bm_checklist_ref WHERE maintenance_checklist_id = '".$maintenanceChceklistId."' "); 

    // insert
    for($i=0; $i<=sizeof($checkedidArr)-1; $i++){
        $insertChecklistRef = "INSERT INTO maintenance_checklist_ref(maintenance_checklist_id, bm_checklist_id, remarks, file)
        VALUES ('".strip_tags($maintenanceChceklistId)."', '".strip_tags($checkedidArr[$i])."', '".strip_tags($remarksArr[$i])."', '".strip_tags($file[$i])."')"; 
        $insertChecklistRefRun = $con->query($insertChecklistRef);

    if($frequency_applicableArr[$i] == 'frequency_applicable' && $calendar == "Yes" && !in_array($frequencyArr[$i], $frqArr)){ 

        if($frequencyArr[$i] == 'Weekly'){

            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($from_date1));
            $current_to_date = date('Y-m-d', strtotime($to_date1));
        
            $from_dates = array();
            $to_dates = array();
        
            while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }
                
                // Check if current_to_date is a Sunday or holiday
                while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                    $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                }
            
                if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
                $to_dates[] = $current_to_date;
                }

                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+7 days'));
                $current_to_date = date('Y-m-d', strtotime($current_to_date . '+7 days'));
            
                if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                    break;
                }
            }
        } 
        if($frequencyArr[$i] == 'Fortnightly'){

            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($from_date1));
            $current_to_date = date('Y-m-d', strtotime($to_date1));
        
            $from_dates = array();
            $to_dates = array();
        
            while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }
                
                // Check if current_to_date is a Sunday or holiday
                while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                    $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                }
            
                if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
                $to_dates[] = $current_to_date;
                }

                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+15 days'));
                $current_to_date = date('Y-m-d', strtotime($current_to_date . '+15 days'));
            
                if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                    break;
                }
            }
        } 

        if($frequencyArr[$i] == 'Monthly'){

            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($from_date1));
            $current_to_date = date('Y-m-d', strtotime($to_date1));
        
            $from_dates = array();
            $to_dates = array();
        
            while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }
                
                // Check if current_to_date is a Sunday or holiday
                while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                    $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                }
            
                if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
                $to_dates[] = $current_to_date;
                }

                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 month'));
                $current_to_date = date('Y-m-d', strtotime($current_to_date . '+1 month'));
            
                if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                    break;
                }
            }
        } 

        if($frequencyArr[$i] == 'Quaterly'){ 

            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($from_date1));
            $current_to_date = date('Y-m-d', strtotime($to_date1));
        
            $from_dates = array();
            $to_dates = array();
        
            while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }
                
                // Check if current_to_date is a Sunday or holiday
                while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                    $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                }
            
                if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
                $to_dates[] = $current_to_date;
                }

                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+3 months'));
                $current_to_date = date('Y-m-d', strtotime($current_to_date . '+3 months'));
            
                if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                    break;
                }
            }
        } 

        if($frequencyArr[$i] == 'Half Yearly'){ 

            $end_of_year = date('Y-12-31');
            $current_from_date = date('Y-m-d', strtotime($from_date1));
            $current_to_date = date('Y-m-d', strtotime($to_date1));
        
            $from_dates = array();
            $to_dates = array();
        
            while ($current_from_date <= $end_of_year && $current_from_date <= $current_to_date) { 
                // Check if current_from_date is a Sunday or holiday
                while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                    $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
                }
                
                // Check if current_to_date is a Sunday or holiday
                while (date('N', strtotime($current_to_date)) == 7 || in_array($current_to_date, $holiday_dates)) {
                    $current_to_date = date('Y-m-d', strtotime('+1 day', strtotime($current_to_date)));
                }
            
                if ($current_from_date <= $end_of_year && $current_to_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
                $to_dates[] = $current_to_date;
                }
                
                $current_from_date = date('Y-m-d', strtotime($current_from_date . '+6 months'));
                $current_to_date = date('Y-m-d', strtotime($current_to_date . '+6 months'));
            
                if ($current_from_date > $end_of_year || $current_to_date > $end_of_year || $current_from_date > $current_to_date) {
                    break;
                }
            }
        } 

        for($j=0; $j<=sizeof($from_dates)-1; $j++){ 

            $insertQry="INSERT INTO bm_checklist_ref(bm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
            role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($insertChecklistRefRun)."', 
            '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_dates[$j].' '.$current_time)."', '".strip_tags($to_dates[$j].' '.$current_time)."', 
            '".strip_tags($role1)."', '".strip_tags($role2)."' )";
            $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);
        } 
        
    } else if ($frequencyArr[$i] == 'Daily Task' && $calendar == "No"){
        //if select Daily Task in frequency then insert record per day for current year. 
        $end_of_year = date('Y-12-31');
        $current_from_date = date('Y-m-d', strtotime($current_date));
    
        $from_dates = array();
    
        while ($current_from_date <= $end_of_year ) {
            // Check if current_from_date is a Sunday or holiday
            while (date('N', strtotime($current_from_date)) == 7 || in_array($current_from_date, $holiday_dates)) {
                $current_from_date = date('Y-m-d', strtotime('+1 day', strtotime($current_from_date)));
            }

            if ($current_from_date <= $end_of_year ) { //if last date is sunday means then it add next year date also so this condition is using.
                $from_dates[] = $current_from_date;
            }

            $current_from_date = date('Y-m-d', strtotime($current_from_date . '+1 DAY'));
        
            if ($current_from_date > $end_of_year ) {
                break;
            }
        }//While END.

        for($a=0; $a <count($from_dates); $a++){

            $insertQry="INSERT INTO bm_checklist_ref(bm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
            role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($insertChecklistRefRun)."', 
            '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_dates[$a].' '.$current_time)."', '".strip_tags($from_dates[$a].' '.$current_time)."', 
            '".strip_tags($role1)."', '".strip_tags($role2)."' )";
            $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
        } 

    } else { 

        $insertQry="INSERT INTO bm_checklist_ref(bm_checklist_id, maintenance_checklist_id, maintenance_checklist_ref_id, checklist, from_date, to_date, role1, 
        role2) VALUES ('".strip_tags($checkedidArr[$i])."', '".strip_tags($maintenanceChceklistId)."', '".strip_tags($insertChecklistRefRun)."', 
        '".strip_tags($checklist_textareaArr[$i])."', '".strip_tags($from_date)."', '".strip_tags($to_date)."', '".strip_tags($role1)."', '".strip_tags($role2)."' )";
        $insresult=$mysqli->query($insertQry) or die("Error ".$mysqli->error);	
        echo $insresult;
    }

}
}

if($updateQry && $insertChecklistRef){
	$message = 1;
}else{
	$message = 0;
}

echo json_encode($message);
?>