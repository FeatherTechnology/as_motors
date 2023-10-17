<?php 
include('../ajaxconfig.php');

$policyarr = array();
$result=$con->query("SELECT * FROM policy_company_creation where status=0 ");
while( $row = $result->fetch_assoc()){
    $policy_company_id = $row['policy_company_id'];
    $policy_company = $row['policy_company'];
    $policyarr[] = array("policy_company_id" => $policy_company_id, "policy_company" => $policy_company);
}

echo json_encode($policyarr);
?>