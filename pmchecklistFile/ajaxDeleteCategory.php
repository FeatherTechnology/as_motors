<?php
include '../ajaxconfig.php';

if(isset($_POST["category_creation_id"])){
	$category_creation_id  = $_POST["category_creation_id"];
}
$isdel = '';

$ctqry=$con->query("SELECT * FROM pm_checklist_ref WHERE category_id = '".$category_creation_id."' ");
while($row=$ctqry->fetch_assoc()){
	$isdel=$row["category_id"];
}

if($isdel != ''){ 
	$message="You Don't Have Rights To Delete This Category";
}
else
{ 
	$delct=$con->query("UPDATE category_creation SET status = 1 WHERE category_creation_id = '".$category_creation_id."' ");
	if($delct){
		$message="Category Inactivated Successfully";
	}
}

echo json_encode($message);
?>