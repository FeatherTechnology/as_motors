<?php
include('ajaxconfig.php');
if(isset($_POST["id"])){
	$id  = $_POST["id"];
}
$qry = "DELETE FROM year_creation WHERE year_id = '$id' ";
$insert_assign = $mysqli->query($qry) or die("Error " . $mysqli->error);

echo json_encode($insert_assign);

?>