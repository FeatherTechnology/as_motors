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
$emp_data = "SELECT tfr.new_assertion,
ROUND(tfr.new_target / $wdays) AS new_target
FROM target_fixing_ref tfr
LEFT JOIN target_fixing tf ON tf.target_fixing_id = tfr.target_fixing_id
WHERE tf.company_id = '$company_id'
AND tf.department_id = '$department_id'
AND tf.role_id = '$designation_id'
AND tf.emp_id = '$emp_id'";
		
		$res = $mysqli->query($emp_data) or die("Error in Get All Records".$mysqli->error);
		$emp_data_list = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object()){
			
				$emp_data_list[$i]['new_assertion']      = $row->new_assertion;
				$emp_data_list[$i]['new_target']      = $row->new_target;
				
				$i++;
			}
		}

        
          echo json_encode($emp_data_list);


?>