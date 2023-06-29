<?php
include('../ajaxconfig.php');
              

$assignid = $_POST['assignid'];
$assignrefid= $_POST['assignrefid']; 
$remark=$_POST['remark']; 
$date=$_POST['date'];
$userid=$_POST['userid'];           
if(!empty($_FILES['file'])){
    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $exp = explode(".", $file_name);
    $ext = end($exp);
    $file = time().'.'.$ext;
    $location = "uploads/followup/".$file;

    move_uploaded_file($file_temp, $location);
}
    mysqli_query($con, "UPDATE audit_assign_ref SET auditee_followup_status = '1' WHERE audit_assign_ref_id = '$assignrefid' AND audit_assign_id = '$assignid'");

    $qry1="INSERT INTO audit_followup (audit_assign_id, audit_assign_ref_id, remarks, completed_date, files,insert_login_id)
    VALUES ('$assignid', '$assignrefid', '$remark', '$date', '$file','$userid')";
    $insert_assign=$mysqli->query($qry1) or die("Error ".$mysqli->error);
  


    
return $insert_assign;

?>