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

$designation_id = array();
$designation_name = array();

$qry1=$con->query("SELECT designation_id,designation_name FROM designation_creation  WHERE company_id = '$company_id'");

while($row1=$qry1->fetch_assoc()){
    $designation_id[] = $row1['designation_id'];
    $designation_name[] = $row1['designation_name'];
   }

for($i=0;$i<count($designation_id); $i++){
    $prevChecklist[$i]['designation_id'] = $designation_id[$i];
    $prevChecklist[$i]['designation_name'] = $designation_name[$i];
}
//  print_r($prevChecklist);

// $staff_id = array();
// $staff_name = array();

// $qry13=$con->query("SELECT staff_id,staff_name FROM staff_creation  WHERE company_id = '$company_id' AND designation IN '$designation_id' AND department_id IN '$department_id'");
// print_r($qry13);
// while($row13=$qry13->fetch_assoc()){
//     $staff_id = $row13['staff_id'];
//     $staff_name = $row13['staff_name'];
//    }

// for($i=0;$i<count($designation_id); $i++){
//     $prevChecklist[$i]['staff_id'] = $staff_id[$i];
//     $prevChecklist[$i]['staff_name'] = $staff_name[$i];
// }

echo json_encode($prevChecklist);

?>