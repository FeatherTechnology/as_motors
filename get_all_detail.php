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


       $emp_data1 = "SELECT tfr.new_assertion, ROUND(tfr.new_target / $wdays) AS new_target, tfr.new_target AS old_target, tfr.target_fixing_id, tfr.target_fixing_ref_id FROM target_fixing_ref tfr LEFT JOIN target_fixing tf ON tf.target_fixing_id = tfr.target_fixing_id LEFT JOIN daily_performance_ref dp ON dp.target_fixing_ref_id = tfr.target_fixing_ref_id  WHERE 
	   tf.company_id = '$company_id'
	   AND tf.department_id = '$department_id'
	   AND tf.designation_id = '$designation_id'
	   AND tf.emp_id = '$emp_id' AND dp.status  NOT IN('statisfied')";
	    $result = $mysqli->query($emp_data1); 
	
if (!empty($result)) {
    $row = $result->fetch_assoc();
	if($row <> ''){
		// echo "if";

        $emp_data = "SELECT
		CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_assertion <> '') THEN tfr.new_assertion ELSE tfr.assertion END END AS assertion,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_target <> '') THEN ROUND(tfr.new_target / $wdays) ELSE ROUND(tfr.target / $wdays)  END END AS new_target,
		CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_target <> '') THEN tfr.new_target ELSE tfr.target END END AS old_target,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		 ELSE tfr.target_fixing_id END AS target_fixing_id,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		 ELSE tfr.target_fixing_ref_id END AS target_fixing_ref_id,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
         ELSE CURDATE() END  AS cdate
		FROM
		target_fixing_ref tfr
		LEFT JOIN target_fixing tf ON tf.target_fixing_id = tfr.target_fixing_id
		LEFT JOIN daily_performance_ref dp ON dp.target_fixing_ref_id = tfr.target_fixing_ref_id 
	      WHERE 
    	 tf.company_id = '$company_id'
    	 AND tf.department_id = '$department_id'
    	 AND tf.designation_id = '$designation_id'
    	 AND tf.emp_id = '$emp_id' AND dp.status  NOT IN('statisfied')";
		//  print_r($emp_data);
	}else{
		// echo "else";
		$emp_data = "SELECT
		CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_assertion <> '') THEN tfr.new_assertion ELSE tfr.assertion END END AS new_assertion,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_target <> '') THEN ROUND(tfr.new_target / $wdays) ELSE ROUND(tfr.target / $wdays)  END END AS new_target,
		CASE WHEN (tfr.deleted_date <> '') THEN  ''
		ELSE CASE WHEN (tfr.new_target <> '') THEN tfr.new_target ELSE tfr.target END END AS old_target,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		 ELSE tfr.target_fixing_id END AS target_fixing_id,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
		 ELSE tfr.target_fixing_ref_id END AS target_fixing_ref_id,
		 CASE WHEN (tfr.deleted_date <> '') THEN  ''
         ELSE CURDATE() END  AS cdate
		FROM
		target_fixing_ref tfr
		LEFT JOIN target_fixing tf ON tf.target_fixing_id = tfr.target_fixing_id
	WHERE
		
                   
	           tf.company_id = '$company_id'
	      AND tf.department_id = '$department_id'
	      AND tf.designation_id = '$designation_id'
	      AND tf.emp_id = '$emp_id' ";
		//  print_r($emp_data);

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