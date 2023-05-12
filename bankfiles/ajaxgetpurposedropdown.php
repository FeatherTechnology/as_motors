<?php 
include('../ajaxconfig.php');
$purposearr = array();
$result=$con->query("SELECT * FROM purpose where 1 and status=0");
while( $row = $result->fetch_assoc()){
      $purposeid = $row['purposeid'];
      $purposename = $row['purposename'];
      $purposearr[] = array("purposeid" => $purposeid, "purposename" => $purposename);
   }
echo json_encode($purposearr);
?>