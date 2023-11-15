<?php 
include('../ajaxconfig.php');
if(isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];
}

$responsiblearr = array();
$result=$con->query("SELECT * FROM responsibility_creation WHERE branch_id='".$branch_id."' AND status=0");
while( $row = $result->fetch_assoc()){
    $responsibility_id = $row['responsibility_id'];
    $responsibility_name = $row['responsibility_name'];
    $responsiblearr[] = array("responsibility_id" => $responsibility_id, "responsibility_name" => $responsibility_name);
}
echo json_encode($responsiblearr);
?>