<?php 
include('../ajaxconfig.php');

$vendornamearr = array();
$result=$con->query("SELECT vendor_name_id, vendor_name  FROM vendor_name_creation where status=0 ");
while( $row = $result->fetch_assoc()){
    $vendor_name_id = $row['vendor_name_id'];
    $vendor_name = $row['vendor_name'];
    $vendornamearr[] = array("vendor_name_id" => $vendor_name_id, "vendor_name" => $vendor_name);
}

echo json_encode($vendornamearr);
?>