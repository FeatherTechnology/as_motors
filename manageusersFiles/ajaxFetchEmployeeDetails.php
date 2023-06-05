<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["staff_name"])){
	$staff_name = $_POST["staff_name"];
}

$designation = array();
$email = array();
$mobilenumber = array();

$getitem = $con->query("SELECT * FROM staff_creation WHERE staff_id = '".$staff_name."' and status=0") OR die("Error: ".$con->error);
while ($row=$getitem->fetch_assoc()){
    $getDesignation = $con->query("SELECT designation_name FROM designation_creation WHERE designation_id = '".$row["designation"]."' ") OR die("Error: ".$con->error);
    while($fetchDesignation = $getDesignation->fetch_assoc()){
        $designation = $fetchDesignation['designation_name'];
    }
    $email[] = $row["email_id"];
    $mobilenumber[]   = $row["contact_number"];
}


$empdetails["designation"] = $designation;
$empdetails["email"] = $email;
$empdetails["mobilenumber"] = $mobilenumber;

echo json_encode($empdetails);
?>