<?php
include('ajaxconfig.php');
date_default_timezone_set('Asia/Calcutta');
$curdate = date('Y-m-d');

if(isset($_POST["staff_id"])){
	$staff_id  = $_POST["staff_id"];
}
// if(isset($_POST["designation_id"])){
// 	$designation_id  = $_POST["designation_id"];
// }

//(gsr.monthly_conversion_required = 0- Monthly, 1-Daily)
//if month conversion is Daily means then the target is divided by working days, if not means target is shown as it is. -- AND (gsr.status != '1' && gsr.status != '2') LEFT JOIN  goal_setting gs ON gsr.goal_setting_id = gs.goal_setting_id
	$goalSettingQry = " SELECT gsr.assertion_table_sno, gsr.assertion, gsr.per_day_target, gsr.goal_setting_id, gsr.goal_setting_ref_id, gsr.goal_month as cdate 
	FROM goal_setting_ref gsr 
	WHERE FIND_IN_SET($staff_id, gsr.staffname) 
	AND gsr.monthly_conversion_required = '1' 
	AND gsr.goal_month = '$curdate' ";

	$goalsettingDetails = $mysqli->query($goalSettingQry) or die("Error in Get All Records".$mysqli->error);
	$i = 0;
	$emp_data_list = array();
	$total_target = 0;
	while($goalsettinginfo = $goalsettingDetails->fetch_object()){
		
	$dprDataCheckQry = "SELECT *
	FROM daily_performance_ref 
	WHERE staff_id = '$staff_id' 
	AND goal_setting_ref_id = '$goalsettinginfo->goal_setting_ref_id' 
	AND MONTH(system_date) = MONTH('$goalsettinginfo->cdate') ";
	$dprDataDetails = $mysqli->query($dprDataCheckQry) or die("Error in Get All Records".$mysqli->error); 
	if(mysqli_num_rows($dprDataDetails) == 0){

	$dprQry = "SELECT sum(target) as total_pending_target, goal_setting_ref_id
	FROM daily_performance_ref 
	WHERE status != '1' 
	AND staff_id = '$staff_id' 
	AND goal_setting_ref_id = '$goalsettinginfo->goal_setting_ref_id' 
	AND MONTH(system_date) = MONTH('$goalsettinginfo->cdate') ";
	
	$dprDetails = $mysqli->query($dprQry) or die("Error in Get All Records".$mysqli->error); 
	while($dprinfo = $dprDetails->fetch_object()){
	$old_target = $dprinfo->total_pending_target;
	$daily_goal_setting_ref_id = $dprinfo->goal_setting_ref_id;
	}

	if($daily_goal_setting_ref_id == $goalsettinginfo->goal_setting_ref_id){ 
		
		$emp_data_list[$i]['target']      	= $old_target + $goalsettinginfo->per_day_target;

	}else if($daily_goal_setting_ref_id == ''){ 

		$goaltargetQry = $mysqli->query(" SELECT sum(gsr.per_day_target) as total_target
		FROM goal_setting_ref gsr 
		LEFT JOIN  goal_setting gs ON gsr.goal_setting_id = gs.goal_setting_id
		WHERE FIND_IN_SET($staff_id, gsr.staffname)  
		AND gsr.monthly_conversion_required = '1'
		AND gsr.assertion_table_sno = '$goalsettinginfo->assertion_table_sno'
		AND gsr.goal_month < '$curdate' 
		 ");  // AND gsr.status != 1 // AND dpr.status != 1  //LEFT JOIN  daily_performance_ref dpr ON gsr.goal_setting_ref_id = dpr.goal_setting_ref_id //, sum(dpr.actual_achieve) as actual
		$goal_target = $goaltargetQry->fetch_assoc();

		$actualAchieveDetials = $mysqli->query("SELECT sum(target) as target, sum(actual_achieve) as actual_achieve FROM `daily_performance_ref` WHERE staff_id = '$staff_id' AND assertion_table_sno = '$goalsettinginfo->assertion_table_sno' ");
		$actualAchieveinfo = $actualAchieveDetials->fetch_assoc();

		if($goal_target['total_target'] != '') {
			$sumvalue = $goal_target['total_target'] - $actualAchieveinfo['actual_achieve'];
			$sumtarget = $goalsettinginfo->per_day_target + $sumvalue ;
			
		} else{
			$sumtarget = $goalsettinginfo->per_day_target; 

		}

		$emp_data_list[$i]['target']      	=  $sumtarget; 
	}else{
		$emp_data_list[$i]['target']      	=  $goalsettinginfo->per_day_target;
	}
					
	$emp_data_list[$i]['assertion']      	= $goalsettinginfo->assertion;
	$emp_data_list[$i]['goal_setting_id']      = $goalsettinginfo->goal_setting_id;
	$emp_data_list[$i]['goal_setting_ref_id']  = $goalsettinginfo->goal_setting_ref_id;
	$emp_data_list[$i]['cdate']    				= $goalsettinginfo->cdate;
	$emp_data_list[$i]['assertion_table_sno']    				= $goalsettinginfo->assertion_table_sno;
	
	$i++;					
}
}

echo json_encode($emp_data_list);























// if(isset($_POST["company_id"])){
// 	$company_id  = $_POST["company_id"];
// }
// if(isset($_POST["department_id"])){
// 	$department_id  = $_POST["department_id"];
// }
// if(isset($_POST["designation_id"])){
// 	$designation_id  = $_POST["designation_id"];
// }
// if(isset($_POST["emp_id"])){
// 	$emp_id  = $_POST["emp_id"];
// }
// if(isset($_POST["wdays"])){
// 	$wdays  = $_POST["wdays"];
// }
// if(isset($_POST["target_fixing_id"])){
// 	$target_fixing_id  = $_POST["target_fixing_id"];
// }
// if(isset($_POST["target_fixing_ref_id"])){
// 	$target_fixing_ref_id  = $_POST["target_fixing_ref_id"];

// }

// $emp_data1 = "SELECT dpr.system_date
// FROM daily_performance_ref dpr
// LEFT JOIN daily_performance dp ON dp.daily_performance_id = dpr.daily_performance_id
// WHERE dp.company_id = '$company_id'
// AND dp.department_id = '$department_id'
// AND dp.role_id = '$designation_id'
// AND dp.emp_id = '$emp_id'
// AND YEAR(dpr.system_date) = YEAR(CURDATE())  
// AND MONTH(dpr.system_date) = MONTH(CURDATE())";
// $result = $mysqli->query($emp_data1); 
	
		
		


// if (!empty($result)) {
//     $row = $result->fetch_assoc();
// 	if($row <> ''){
// 		// echo "if";
// 		$emp_data = "SELECT dpr.assertion, dpr.target, dpr.goal_setting_id, dpr.goal_setting_ref_id, CURDATE() AS cdate 
// 		FROM daily_performance dp 
// 		LEFT JOIN daily_performance_ref dpr ON dpr.daily_performance_id = dp.daily_performance_id
// 		WHERE dp.emp_id ='$emp_id'
// 		AND MONTH(dpr.system_date) = MONTH(CURDATE())
// 		AND dpr.status != '1' GROUP BY dpr.goal_setting_ref_id";
	
        
// 	}else{
		
// 	//echo "else"; // (gsr.monthly_conversion_required = 0- Monthly, 1-Daily)
// 	//if month conversion is Daily means then the target is divided by working days, if not means target is shown as it is.
// 		$emp_data = " SELECT gsr.assertion, gsr.target, gs.goal_setting_id, gsr.goal_setting_ref_id, CURDATE() AS cdate 
// 		FROM goal_setting_ref gsr 
// 		LEFT JOIN  goal_setting gs ON gsr.goal_setting_id = gs.goal_setting_id
// 		WHERE gs.company_name = '$company_id' 
// 		AND gs.department = '$department_id' 
// 		AND gs.role = '$designation_id' 
// 		AND gsr.monthly_conversion_required = '1' group by gsr.assertion";
// 	}
	
// 		//  echo $emp_data;
// 	$res = $mysqli->query($emp_data) or die("Error in Get All Records".$mysqli->error);
		
		
// 			$emp_data_list = array();
// 			$goalRefid = array();
// 			$ref_id = array();
// 			$i=0;
// 			$j=0;
// 			$new_target1= 0;
// 			if ($mysqli->affected_rows>0)
// 			{
// 				//The Daily Performance is inserting all the target for every time so it have duplicate record but we want daily performance status history so we inserting like that. Once the target is satisfied then remaining target only to show but here it getting all record because of duplicate record so we filter the record by using "target_fixing_ref_id", checking if one of the "target_fixing_ref_id" is satisfied then the "target_fixing_ref_id" mention as satisfied so it will be not show in the list. The list has to show only not done and carry_forward record.     
// 						$res11 = $mysqli->query($emp_data) or die("Error in Get All Records".$mysqli->error);
// 						while($row11 = $res11->fetch_object()){
						
// 							$goalRefid[] = $row11->goal_setting_ref_id;
// 						}
// 						foreach($goalRefid as $key => $value){
// 							$dpr = $con->query("select * from daily_performance_ref where goal_setting_ref_id = '".$value."' ");
// 							$ref_id[$value] = '2';
// 							while($dailyPerformance = $dpr->fetch_assoc()){
// 								if($ref_id[$value] == '2' && $dailyPerformance['status'] == '1'){
// 									$ref_id[$value] = $dailyPerformance['status'];
// 								}
// 							}
							
// 						}
// 				while($row = $res->fetch_object()){
				
// 					$data = $row->assertion;
// 						if($data == ''){
						
						
// 						}else{
							
// 						if($ref_id[$row->goal_setting_ref_id] != '1'){ //Show target List except 'satisfied'
							
// 							$qry5 = "SELECT sum(target) as total_pending_target, goal_setting_ref_id
// 							FROM daily_performance_ref WHERE status != '1' AND goal_setting_ref_id = '$row->goal_setting_ref_id' AND MONTH(system_date) = MONTH(CURDATE()) ";
// 							// echo $qry5;
// 							$res5 = $mysqli->query($qry5) or die("Error in Get All Records".$mysqli->error);
// 							while($row5 = $res5->fetch_object()){
// 							$new_target1 = $row5->total_pending_target;
// 							$daily_goal_setting_ref_id = $row5->goal_setting_ref_id;
// 							}

// 							if($daily_goal_setting_ref_id == $row->goal_setting_ref_id){  //echo 'aaaaa';
								
// 								$emp_data_list[$i]['target']      	= $new_target1 + $row->target;

// 							}else{
// 								$emp_data_list[$i]['target']      	=  $row->target;
// 							}
											
// 							$emp_data_list[$i]['assertion']      	= $row->assertion;
// 							// $emp_data_list[$i]['target']      		= $row->target;
// 							$emp_data_list[$i]['goal_setting_id']      = $row->goal_setting_id;
// 							$emp_data_list[$i]['goal_setting_ref_id']  = $row->goal_setting_ref_id;
// 							$emp_data_list[$i]['cdate']    				= $row->cdate;
							
// 							$i++;					
// 						}
// 					}
					
// 				}
				
// 			}
			
			
// 	$response = array(
// 		'emp_data_list' => $emp_data_list
// 	);
			
// 	echo json_encode($response);
// } 
	
	
		


?>