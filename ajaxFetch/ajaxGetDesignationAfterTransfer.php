<?php 
include('../ajaxconfig.php');

if(isset($_POST['staff_id'])){
    $staff_id = $_POST['staff_id'];
}

$getdesgnDetails = $con->query("SELECT tl.transfer_effective_from, sch.designation FROM `transfer_location` tl LEFT JOIN staff_creation_history sch ON tl.transfer_location_id = sch.transfer_location_id WHERE tl.staff_code = '$staff_id' order by tl.transfer_location_id DESC LIMIT 1");
if(mysqli_num_rows($getdesgnDetails)>0){
    $dsgnInfo = $getdesgnDetails->fetch_assoc();
    $transfer_effective_from = date('Y-m-d',strtotime($dsgnInfo['transfer_effective_from'])); 
    $curdates = date('Y-m-d');

    if($transfer_effective_from > $curdates){
        $designation = $dsgnInfo['designation'];
        
    }else{
        $designation = 0;
    }
}else{
    $designation = 0;
}

echo json_encode($designation);
?>