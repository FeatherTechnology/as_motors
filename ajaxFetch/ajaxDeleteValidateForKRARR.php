<?php 
include('../ajaxconfig.php');

if(isset($_POST['cellValue'])){
    $cellValue = $_POST['cellValue'];
}
if(isset($_POST['cellKey'])){
    $cellKey = $_POST['cellKey'];
}

$getDetails = $con->query("SELECT * FROM `krakpi_creation_ref` WHERE $cellKey = '$cellValue' ");
if(mysqli_num_rows($getDetails)>0){
    $cntvalue = 1;

}else{
    $cntvalue = 0;
}

echo json_encode($cntvalue);
?>