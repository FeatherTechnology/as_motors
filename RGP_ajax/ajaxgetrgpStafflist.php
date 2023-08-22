<?php
include '../ajaxconfig.php';

if(isset($_POST["branch_id_from"])){
	$branch_id_from = $_POST["branch_id_from"];
}
if(isset($_POST["branch_id_to"])){
	$branch_id_to = $_POST["branch_id_to"];
}

$staff_id   = array();
$staff_name = array();

$getInstName=$con->query("SELECT sc.staff_id, sc.staff_name, sc.emp_code, bc.branch_name FROM staff_creation sc LEFT JOIN branch_creation bc ON sc.company_id = bc.branch_id WHERE (sc.company_id = '$branch_id_from' || sc.company_id = '$branch_id_to' ) AND sc.status = 0");
while($row2=$getInstName->fetch_assoc()){
    $staff_id[]         = $row2["staff_id"];
    $staff_name[]       = $row2["staff_name"];
    $emp_code[]         = $row2["emp_code"];
    $branch_name[]      = $row2["branch_name"];
} 

$staffinfo["staff_id"]      = $staff_id;
$staffinfo["staff_name"]    = $staff_name;
$staffinfo["emp_code"]      = $emp_code;
$staffinfo["branch_name"]   = $branch_name;
    
echo json_encode($staffinfo);
?>