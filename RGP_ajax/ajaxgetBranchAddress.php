<?php
include '../ajaxconfig.php';

if(isset($_POST['branch_id'])){
    $branch_id = $_POST['branch_id'];
}
$address = array();
$getct = "SELECT * FROM branch_creation WHERE branch_id = '".$branch_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $address['address1'] = $row['address1'];
    $address['address2'] = $row['address2'];
}

echo json_encode($address);
?>