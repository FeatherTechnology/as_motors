<?php 
include('../ajaxconfig.php');

if (isset($_POST['company_id'])) {
   $company_id = $_POST['company_id'];
}
if (isset($_POST['department_upd'])) {
   $department_upd = $_POST['department_upd'];
}

$departmentarr = array();
$result=$con->query("SELECT * FROM department_creation WHERE company_id='".$company_id."' AND status=0");
while( $row = $result->fetch_assoc()){
      $department_id = $row['department_id'];
      $department_name = $row['department_name'];
      $departmentarr[] = array("department_id" => $department_id, "department_name" => $department_name);
   }
echo json_encode($departmentarr);
?>