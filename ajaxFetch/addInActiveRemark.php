<?php 
include('../ajaxconfig.php');

@session_start();

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}

if(isset($_POST['idColumn'])){
    $idColumn = $_POST['idColumn'];
}
if(isset($_POST['rowId'])){
    $id = $_POST['rowId'];
}

if(isset($_POST['tableName'])){
    $table_name = $_POST['tableName'];
}

if(isset($_POST['remark'])){
    $remark = $_POST['remark'];
}

$qryDetails = $con->query(" UPDATE $table_name set status='1', in_active_remark = '$remark', delete_login_id='$userid' WHERE $idColumn = '$id' ");

if($qryDetails){
    $message = 1;
}else{
    $message = 0;
}

echo json_encode($message);
?>