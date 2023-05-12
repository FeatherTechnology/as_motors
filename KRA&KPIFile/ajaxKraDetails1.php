<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id_upd"])){
	$company_id_upd = $_POST["company_id_upd"]; 
}
if(isset($_POST["department"])){
    $department = $_POST["department"];
}
if(isset($_POST["designation"])){
    $designation = $_POST["designation"];
}

$kra_id = '';
$kra_category = array();
$kra_creation_ref_id = array();

// get kra id name 
$getInstName=$con->query("SELECT kra_id FROM kra_creation WHERE status = 0 AND company_id = $company_id_upd AND department_id ='" . strip_tags($department) . "' 
AND designation_id = '" . strip_tags($designation) . "' ");
$row2=$getInstName->fetch_assoc();
$kra_id    = $row2["kra_id"]; 


// for($i=0; $i<=sizeof($kra_id)-1; $i++){
$getqry = "SELECT * FROM kra_creation_ref WHERE kra_id ='".strip_tags($kra_id)."'"; 
$res12 = $con->query($getqry);
while($row12 = $res12->fetch_assoc())
{
    $kra_creation_ref_id[] = $row12["kra_creation_ref_id"];        
    $kra_category[] = $row12["kra_category"];        
}
//  } 

$designationDetails["kra_creation_ref_id"] = $kra_creation_ref_id ;
$designationDetails["kra_category"] = $kra_category; 

echo json_encode($designationDetails);
?>