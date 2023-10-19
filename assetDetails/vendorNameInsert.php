<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if(isset($_SESSION['curdateFromIndexPage'])) {
    $curdate = $_SESSION['curdateFromIndexPage'];
}
if (isset($_POST['vendor_name_id'])) {
    $vendor_name_id = $_POST['vendor_name_id'];
}
if (isset($_POST['vendor_name_create'])) {
    $vendor_name_create = $_POST['vendor_name_create'];
}


$vendorname='';
$vendorStatus='';
$getvendorinfo = $con->query("SELECT vendor_name, status  FROM vendor_name_creation WHERE vendor_name = '".$vendor_name_create."' ");
if(mysqli_num_rows($getvendorinfo) > 0){
	while ($row=$getvendorinfo->fetch_assoc()){
		$vendorname    = $row["vendor_name"];
		$vendorStatus  = $row["status"];
	}
}

if($vendorname != '' && $vendorStatus == 0){
	$message="Vendor Name Already Exists, Please Enter a Different Name!";
}
else if($vendorname != '' && $vendorStatus == 1){
	$updateassetQry=$con->query("UPDATE vendor_name_creation SET status=0 WHERE vendor_name ='".$vendor_name_create."' ");
	$message="Vendor Name Added Succesfully";
}
else{
	if($vendor_name_id != ''){
		$updateassetname=$con->query("UPDATE vendor_name_creation SET vendor_name ='$vendor_name_create', update_login_id = '$userid', updated_date = '$curdate' WHERE vendor_name_id='$vendor_name_id' ");
		if($updateassetname == true){
            $message="Vendor Name Updated Succesfully";
        }
    }
	else{
        $insertassetname=$con->query("INSERT INTO vendor_name_creation(vendor_name , insert_login_id, created_date) VALUES('$vendor_name_create', '$userid', '$curdate' )");
        if($insertassetname == true){
            $message="Vendor Name Added Succesfully";
        }
    }
}

echo json_encode($message);
?>