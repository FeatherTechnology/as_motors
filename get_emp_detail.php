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
$emp_data = "SELECT * FROM staff_creation WHERE company_id='$company_id' AND designation='$designation_id' AND department='$department_id' AND status='0'";
	
		$res = $mysqli->query($emp_data) or die("Error in Get All Records".$mysqli->error);
		$emp_data_list = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object()){
			
				$emp_data_list[$i]['staff_id']      = $row->staff_id;
				$emp_data_list[$i]['staff_name']      = $row->staff_name;
				
				$i++;
			}
		}

        
          echo json_encode($emp_data_list);


?>