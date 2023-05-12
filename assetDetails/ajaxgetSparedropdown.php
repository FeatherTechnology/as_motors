<?php 
include('../ajaxconfig.php');
if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
}

$designationarr = array();
$result=$con->query("SELECT * FROM spare_creation where branch_id = '".$branch_id."' and status=0");
while( $row = $result->fetch_assoc()){
      $spare_id = $row['spare_id'];
      $spare_name = $row['spare_name'];
      $designationarr[] = array("spare_id" => $spare_id, "spare_name" => $spare_name);
   }
echo json_encode($designationarr);
?>