<?php
include '../ajaxconfig.php';

if(isset($_POST["staffcode"])){
	$staffcode = $_POST["staffcode"];
}
if(isset($_POST["editInsert"])){
	$editInsert = $_POST["editInsert"];
}

$krakpiDetails = array();

// get KRAKPI
    if($editInsert == '1'){
        $getDepartmentId = $con->query("SELECT kc.krakpi_id, kc.company_name, kc.designation, dc.designation_name FROM krakpi_creation kc LEFT JOIN designation_creation dc ON kc.designation = dc.designation_id WHERE kc.status=0 ORDER BY krakpi_id ASC");

    }else{
        $getDepartmentId = $con->query("SELECT kc.krakpi_id, kc.company_name, kc.designation, dc.designation_name, sc.staff_name FROM krakpi_creation kc LEFT JOIN designation_creation dc ON kc.designation = dc.designation_id LEFT JOIN staff_creation sc ON kc.designation = sc.designation WHERE sc.staff_id = ".$staffcode." AND kc.status=0 ORDER BY krakpi_id ASC");

    }
    while($deptinfo=$getDepartmentId->fetch_assoc()){
        $krakpi_id = $deptinfo["krakpi_id"];        
        $designation_name = $deptinfo["designation_name"];    
		
		$krakpiDetails[] = array("krakpi_id" => $krakpi_id, "designation_name" => $designation_name);
    }

echo json_encode($krakpiDetails);
?>