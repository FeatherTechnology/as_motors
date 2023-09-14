<?php 
//Also using in transfer_location.js.
include('../ajaxconfig.php');

$company_names = array();
$getCompanyDetails = $con->query("SELECT company_id, company_name FROM company_creation WHERE  status = '0' ");
while($companyInfo = $getCompanyDetails->fetch_assoc()){
    $company_id = $companyInfo['company_id'];
    $company_name = $companyInfo['company_name'];

    $company_names[] = array("companyId" => $company_id, "companyName" => $company_name);
}

echo json_encode($company_names);
?>