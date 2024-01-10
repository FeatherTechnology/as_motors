<?php 
include('../ajaxconfig.php');
if(isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}
if(isset($_POST['dept'])) {
    $dept = $_POST['dept'];
}

$assertionArr = array();
$result=$con->query("SELECT * FROM assertion_creation WHERE dept_id = '".$dept."' AND status=0");
while( $row = $result->fetch_assoc()){
    $assertion_id = $row['assertion_id'];
    $assertion = $row['assertion'];
    $assertionArr[] = array("assertion_id" => $assertion_id, "assertion" => $assertion);
}
echo json_encode($assertionArr);
?>