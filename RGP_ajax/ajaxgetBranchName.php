<?php
///Using in goal_setting.js page also. To Get Branch name based on company.
include '../ajaxconfig.php';

if(isset($_POST['company_id'])){
    $company_id = $_POST['company_id'];
}
$assetDetails = array();
$getct = "SELECT * FROM branch_creation WHERE company_id = '".$company_id."' AND status=0";
$result = $con->query($getct);
$i = 0;
while($row=$result->fetch_assoc())
{
    $assetDetails[$i]['branch_name'] = $row['branch_name'];
    $assetDetails[$i]['branch_id'] = $row['branch_id'];
    $i++;
}

echo json_encode($assetDetails);

// Close the database connection
mysqli_close($con);
?>