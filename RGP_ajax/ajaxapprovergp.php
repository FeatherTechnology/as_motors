<?php
include '../ajaxconfig.php';

if(isset($_POST['rgp_id'])){
    $rgp_id = $_POST['rgp_id'];
}


$getct = "UPDATE rgp_creation set extend_status = 'Approved'  WHERE rgp_id = '".$rgp_id."' ";
$result = $con->query($getct);

if($result and $result1){
    $message = "RGP Extention Approved";
}
else{
    $message = "Error";
}

echo json_encode($message);
?>