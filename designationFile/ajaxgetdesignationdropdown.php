<?php 
include('../ajaxconfig.php');
if(isset($_POST['company_id'])) {
   $company_id = $_POST['company_id'];
}

$designationarr = array();
$result=$con->query("SELECT * FROM designation_creation WHERE company_id='".$company_id."' AND status=0");
while( $row = $result->fetch_assoc()){
      $designation_id = $row['designation_id'];
      $designation_name = $row['designation_name'];
      $designationarr[] = array("designation_id" => $designation_id, "designation_name" => $designation_name);
   }
echo json_encode($designationarr);
?>