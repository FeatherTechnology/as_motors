<?php
include('ajaxconfig.php');

if(isset($_POST["branchid"])){
	$branchid  = $_POST["branchid"];
}

$departmentDetails = array();

$getDepartmentId = $con->query("SELECT dc.department_id, dc.department_name FROM basic_creation bc LEFT JOIN department_creation dc ON bc.department = dc.department_id WHERE bc.company_id ='$branchid' AND bc.status = 0 GROUP BY bc.department ");
while($dept=$getDepartmentId->fetch_assoc()){
    $department_id = $dept["department_id"];
    $department_name = $dept["department_name"];

    $departmentDetails[] = array("department_id"=> $department_id, "department_name" => $department_name);
}

echo json_encode($departmentDetails);

// Close the database connection
$mysqli->close();
?>