<?php
include('ajaxconfig.php');

if(isset($_POST["comid"])){
	$comid  = $_POST["comid"];
}
$dailyperform = "SELECT * FROM department_creation WHERE company_id = '$comid' AND status='0'";
		
		$res = $mysqli->query($dailyperform) or die("Error in Get All Records".$mysqli->error);
		$dailyperform_list = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row = $res->fetch_object()){
			
				$dailyperform_list[$i]['department_id']      = $row->department_id;
				$dailyperform_list[$i]['department_name']      = $row->department_name;
				
				$i++;
			}
		}

        $dailyperform1 = "SELECT * FROM `designation_creation` WHERE company_id='$comid' AND status='0'";
		
		$res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records".$mysqli->error);
		$dailyperform_list1 = array();
		$i=0;

		if ($mysqli->affected_rows>0)
		{
			while($row1 = $res1->fetch_object()){
			
				$dailyperform_list1[$i]['designation_id']      = $row1->designation_id;
				$dailyperform_list1[$i]['designation_name']      = $row1->designation_name;
				
				$i++;
			}
		}
        $response = array(
            'departments' => $dailyperform_list,
            'designations' => $dailyperform_list1
          );
        
        //  print_r($response);
          echo json_encode($response);


?>