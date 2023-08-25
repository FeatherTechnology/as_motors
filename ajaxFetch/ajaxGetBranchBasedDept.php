<?php
include '../ajaxconfig.php';

if(isset($_POST["branchId"])){
	$branchId = $_POST["branchId"];
}

$departmentDetails = array();

// get department
foreach ($branchId as $branch_id) {
    
    $getDepartmentId = $con->query("SELECT department_id, department_name FROM basic_creation bc LEFT JOIN department_creation dc ON bc.department = dc.department_id WHERE bc.company_id ='$branch_id' AND bc.status = 0 group by  department_id ");
    while($deptinfo=$getDepartmentId->fetch_assoc()){
        $department_id = $deptinfo["department_id"];        
        $department_name = $deptinfo["department_name"];    
		
		$departmentDetails[] = array("department_id" => $department_id, "department_name" => $department_name);
    }
} 

echo json_encode($departmentDetails);

?>