<?php
include('ajaxconfig.php');

if(isset($_POST["yid"])){
    $yid  = $_POST["yid"];
}

		
		$get_checklist = "SELECT gsr.assertion,gsr.target FROM goal_setting gs LEFT JOIN year_creation y ON y.year_id = gs.year LEFT JOIN goal_setting_ref gsr ON gs.goal_setting_id=gsr.goal_setting_id WHERE y.year_id = '$yid'";
	
		$res2 = $mysqli->query($get_checklist) or die("Error in Get All Records".$mysqli->error);
		$i=0;
		$auditChecklist2='';
		$auditChecklist2=array();
		if ($mysqli->affected_rows>0)
		{
			while($row2 = $res2->fetch_assoc()){
			$auditChecklist2[$i]['assertion'] = $row2['assertion'];
			$auditChecklist2[$i]['target'] = $row2['target'];
					
			$i++;
			}
		}
    
	
        echo json_encode($auditChecklist2);
	
    ?>