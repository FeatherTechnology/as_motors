<?php
include('ajaxconfig.php');

if(isset($_POST["company_id"])){
	$company_id  = $_POST["company_id"];
}
if(isset($_POST["department_id"])){
	$department_id  = $_POST["department_id"];
}
if(isset($_POST["designation_id"])){
	$designation_id  = $_POST["designation_id"];
}
if(isset($_POST["emp_id"])){
	$emp_id  = $_POST["emp_id"];
}
if(isset($_POST["wdays"])){
	$wdays  = $_POST["wdays"];
}
if(isset($_POST["target_fixing_id"])){
	$target_fixing_id  = $_POST["target_fixing_id"];
}
if(isset($_POST["target_fixing_ref_id"])){
	$target_fixing_ref_id  = $_POST["target_fixing_ref_id"];
}


       $emp_data1 = "SELECT dpr.system_date
	   FROM daily_performance_ref dpr
	   LEFT JOIN daily_performance dp ON dp.daily_performance_id = dpr.daily_performance_id
	   WHERE dp.company_id = '$company_id'
		 AND dp.department_id = '$department_id'
		 AND dp.role_id = '$designation_id'
		 AND dp.emp_id = '$emp_id'
		 AND YEAR(dpr.system_date) = YEAR(CURDATE())  
		 AND MONTH(dpr.system_date) = MONTH(CURDATE())";
	    $result = $mysqli->query($emp_data1); 
	
		
		


if (!empty($result)) {
    $row = $result->fetch_assoc();
	if($row <> ''){
		echo "if";
// 	$emp_data = "SELECT
	// 	CASE WHEN (tfr.deleted_date <> '') THEN  ''
	// 	ELSE CASE WHEN (tfr.new_assertion <> '') THEN tfr.new_assertion ELSE tfr.assertion END END AS new_assertion,
	// 	 CASE WHEN (tfr.deleted_date <> '') THEN  ''
	// 	ELSE CASE WHEN (tfr.new_target <> '') THEN ROUND(tfr.new_target / $wdays) ELSE ROUND(tfr.target / $wdays)  END END AS new_target,
	// 	CASE WHEN (tfr.deleted_date <> '') THEN  ''
	// 	ELSE CASE WHEN (tfr.new_target <> '') THEN tfr.new_target ELSE tfr.target END END AS old_target,
	// 	 CASE WHEN (tfr.deleted_date <> '') THEN  ''
	// 	 ELSE tfr.target_fixing_id END AS target_fixing_id,
	// 	 CASE WHEN (tfr.deleted_date <> '') THEN  ''
	// 	 ELSE tfr.target_fixing_ref_id END AS target_fixing_ref_id,
	// 	 CASE WHEN (tfr.deleted_date <> '') THEN  ''
    //      ELSE CURDATE() END  AS cdate
	// 	FROM
	// 	target_fixing_ref tfr
	// 	LEFT JOIN target_fixing tf ON tf.target_fixing_id = tfr.target_fixing_id
	// WHERE
		
                   
	//            tf.company_id = '$company_id'
	//       AND tf.department_id = '$department_id'
	//       AND tf.designation_id = '$designation_id'
	//       AND tf.emp_id = '$emp_id' ";
	// 	//  print_r($emp_data);
        
	}else{
	// 	// echo "else";
	
	$emp_data = "SELECT   
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  '' ELSE CASE WHEN (tfr.new_assertion <> '') THEN tfr.new_assertion ELSE tfr.assertion END END END AS new_assertion,
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  '' ELSE CASE WHEN (tfr.new_target <> '') THEN ROUND(tfr.new_target / $wdays) ELSE ROUND(tfr.target / $wdays)  END END END AS new_target,
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  '' ELSE CASE WHEN (tfr.new_target <> '') THEN tfr.new_target ELSE tfr.target END END END AS old_target,
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  '' ELSE tfr.target_fixing_id END END AS target_fixing_id,
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  ''ELSE tfr.target_fixing_ref_id END END AS target_fixing_ref_id,
	CASE WHEN(dpr.status = 'statisfied') THEN '' ELSE CASE WHEN (tfr.deleted_date <> '') THEN  '' ELSE CURDATE() END END AS cdate
	FROM daily_performance dp 
	LEFT JOIN daily_performance_ref dpr ON dpr.daily_performance_id=dp.daily_performance_id
	LEFT JOIN target_fixing_ref tfr ON tfr.target_fixing_ref_id = dpr.target_fixing_ref_id
	LEFT JOIN target_fixing tf ON tf.target_fixing_id=tfr.target_fixing_id
	
	WHERE dp.company_id ='$company_id'
	AND dp.department_id ='$department_id'
	AND dp.role_id = '$designation_id'
	AND dp.emp_id ='$emp_id'";
	
	}
		$res = $mysqli->query($emp_data) or die("Error in Get All Records".$mysqli->error);
		
		
			$emp_data_list = array();
			$i=0;

			if ($mysqli->affected_rows>0)
			{
				while($row = $res->fetch_object()){
				
					$data = $row->new_assertion;
					
				       if($data == ''){
						
						
					   }else{
							$emp_data_list[$i]['new_assertion']      = $row->new_assertion;
							$emp_data_list[$i]['new_target']      = $row->new_target;
							$emp_data_list[$i]['old_target']      = $row->old_target;
							$emp_data_list[$i]['target_fixing_id']      = $row->target_fixing_id;
							$emp_data_list[$i]['target_fixing_ref_id']      = $row->target_fixing_ref_id;
							$emp_data_list[$i]['cdate']                     = $row->cdate;
							$i++;					
					   }
					
				}
			}
			
			echo json_encode($emp_data_list);
} 
	
	
		


?>