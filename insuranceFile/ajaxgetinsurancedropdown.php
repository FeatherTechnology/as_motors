<?php 
@session_start();
include('../ajaxconfig.php');

if(isset($_POST["company_id"])){
    $company_id = $_POST["company_id"];
}

$insurancearr = array();
$result=$con->query("SELECT * FROM insurance_creation where status=0 and company_id='".$company_id."' ");
while( $row = $result->fetch_assoc()){
    $insurance_id = $row['insurance_id'];
    $insurance_name = $row['insurance_name'];
    $insurancearr[] = array("insurance_id" => $insurance_id, "insurance_name" => $insurance_name);
}

echo json_encode($insurancearr);
?>