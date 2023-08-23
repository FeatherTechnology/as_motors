<?php
include '../ajaxconfig.php';

$idupd = '';
if(isset($_POST["idupd"])){
	$idupd = $_POST["idupd"];
}
$designationEdit = '';
if(isset($_POST["designationEdit"])){
	$designationEdit = $_POST["designationEdit"]; 
}

$staffqry =$con->query("SELECT * FROM staff_creation sc WHERE sc.designation = '$designationEdit' AND sc.status = 0 AND sc.staff_id != '$idupd' ");

    if(mysqli_num_rows($staffqry) > 0){
        $result = '1';
    }else{
        $result = '0';
    }  

echo json_encode($result);
?>