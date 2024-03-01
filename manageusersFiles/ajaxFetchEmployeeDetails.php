<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["staff_name"])){
	$staff_name = $_POST["staff_name"];
}

$getitem = $con->query("SELECT sc.email_id, sc.contact_number, sc.designation, sc.company_id, dc.designation_name FROM staff_creation sc LEFT JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE sc.staff_id = '".$staff_name."' and sc.status=0") OR die("Error: ".$con->error);
$row=$getitem->fetch_assoc();

$empdetails["designation"] = $row['designation_name'];
$empdetails["email"] = $row["email_id"];
$empdetails["mobilenumber"] = $row["contact_number"];
$empdetails["desgn_id"] = $row["designation"];
$empdetails["branch_id"] = $row["company_id"];

echo json_encode($empdetails);
?>