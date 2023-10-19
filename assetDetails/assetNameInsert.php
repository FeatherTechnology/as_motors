<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if(isset($_SESSION['curdateFromIndexPage'])) {
    $curdate = $_SESSION['curdateFromIndexPage'];
}
if (isset($_POST['asset_name_id'])) {
    $asset_name_id = $_POST['asset_name_id'];
}
if (isset($_POST['asset_name_create'])) {
    $asset_name_create = $_POST['asset_name_create'];
}


$assetname='';
$assetStatus='';
$getassetinfo = $con->query("SELECT asset_name, status FROM asset_name_creation WHERE asset_name = '".$asset_name_create."' ");
if(mysqli_num_rows($getassetinfo) > 0){
	while ($row=$getassetinfo->fetch_assoc()){
		$assetname    = $row["asset_name"];
		$assetStatus  = $row["status"];
	}
}

if($assetname != '' && $assetStatus == 0){
	$message="Asset Name Already Exists, Please Enter a Different Name!";
}
else if($assetname != '' && $assetStatus == 1){
	$updateassetQry=$con->query("UPDATE asset_name_creation SET status=0 WHERE asset_name='".$asset_name_create."' ");
	$message="Asset Name Added Succesfully";
}
else{
	if($asset_name_id != ''){
		$updateassetname=$con->query("UPDATE asset_name_creation SET asset_name='$asset_name_create', update_login_id = '$userid', updated_date = '$curdate' WHERE asset_name_id='$asset_name_id' ");
		if($updateassetname == true){
            $message="Asset Name Updated Succesfully";
        }
    }
	else{
        $insertassetname=$con->query("INSERT INTO asset_name_creation(asset_name, insert_login_id, created_date) VALUES('$asset_name_create', '$userid', '$curdate' )");
        if($insertassetname == true){
            $message="Asset Name Added Succesfully";
        }
    }
}

echo json_encode($message);
?>