<?php
include '../ajaxconfig.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}
if(isset($_POST['rgp_id'])){
    $rgp_id = $_POST['rgp_id'];
}


$getct = "UPDATE rgp_creation set extend_status = 'Rejected', updated_id = '$userid', updated_date = now()  WHERE rgp_id = '".$rgp_id."' ";
$result = $con->query($getct);

if($result and $result1){
    $message = "RGP Extention Rejected";
}
else{
    $message = "Error";
}

echo json_encode($message);
?>