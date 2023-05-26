<?php
include('ajaxconfig.php');

if(isset($_POST["prev_company"])){
	$company_id  = $_POST["prev_company"];
}




$department_id = array();
$department_name = array();


$qry=$con->query("SELECT department_id,department_name FROM department_creation  WHERE  company_id = '$company_id'");

while($row=$qry->fetch_assoc()){
    $department_id[] = $row['department_id'];
    $department_name[] = $row['department_name'];
   }

for($i=0;$i<count($department_id); $i++){
    $prevChecklist[$i]['department_id'] = $department_id[$i];
    $prevChecklist[$i]['department_name'] = $department_name[$i];
}




echo json_encode($prevChecklist);

?>