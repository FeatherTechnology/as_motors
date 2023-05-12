<?php
include('../ajaxconfig.php');

if(isset($_POST['purposeid'])) {
    $purposeid = $_POST['purposeid'];
}
if(isset($_POST['purposename'])) {
    $purposename = $_POST['purposename'];
}

$pname = '';
$pstatus = '';

$purposeselect=$con->query("SELECT * FROM purpose WHERE purposename = '".$purposename."' ");
while ($row=$purposeselect->fetch_assoc()){
	$pname   = $row["purposename"];
	$pstatus = $row["status"];
}


if($pname != '' && $pstatus=0){
	$message="Purpose Already Exists, Please Enter a Different Name!";
}
else if($pname != '' && $pstatus=1){
	$update=$con->query("UPDATE purpose SET status=0 WHERE purposename='".$purposename."'   ");
	$message="Purpose Added Succesfully";
}
else{
	if($purposeid>0){
		$update=$con->query("UPDATE purpose SET purposename='".$purposename."' WHERE purposeid='".$purposeid."' ");
		if($update == true){
		$message="Purpose Updated Succesfully";
	    }}
	    else{
	    $insert=$con->query("INSERT INTO purpose(purposename) VALUES('".strip_tags($purposename)."')");
	    if($insert == true){
		$message="Purpose Added Succesfully";
	}}} 

	echo json_encode($message);
	?>

