<?php
include('ajaxconfig.php');

if(isset($_POST["company_id"])){
	$company_id  = $_POST["company_id"];
}
$dailyperform = "SELECT * FROM department_creation WHERE company_id = '$company_id' AND status='0'";
		
		$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
		$dailyperform_list = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object()){
			
				$dailyperform_list[$i]['department_id']      = $row->department_id;
				$dailyperform_list[$i]['department_name']      = $row->department_name;
				$dept_id = $row->department_id;
				$i++;
			}
		}


    
        $response = array(
            'departments' => $dailyperform_list
          );
        
       
          echo json_encode($response);


?>