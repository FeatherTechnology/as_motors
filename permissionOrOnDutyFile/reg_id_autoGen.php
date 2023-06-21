<?php
include('../ajaxconfig.php');

$id  = $_POST['id'];

if($id !=''){
    $select = $con->query("SELECT regularisation_id FROM permission_or_on_duty WHERE permission_on_duty_id = '$id' ");
    $code = $select ->fetch_assoc();
    $reg_id = $code['regularisation_id'];

}else{
$myStr = "R";
$selectIC = $con->query("SELECT regularisation_id FROM permission_or_on_duty WHERE permission_on_duty_id != '' ");
if($selectIC->num_rows>0)
{
    $codeAvailable = $con->query("SELECT regularisation_id FROM permission_or_on_duty WHERE permission_on_duty_id != '' ORDER BY permission_on_duty_id DESC LIMIT 1");
    while($row = $codeAvailable->fetch_assoc()){
        $ac2 = $row["regularisation_id"];
    }
    $appno2 = ltrim(strstr($ac2, '-'), '-'); $appno2 = $appno2+1;
    $reg_id = $myStr."-". "$appno2";
}
else
{
    $initialapp = $myStr."-101";
    $reg_id = $initialapp;
}
}
echo json_encode($reg_id);
?>