<?php
include '../ajaxconfig.php';

if (isset($_POST['category_creation_id'])) {
    $category_creation_id = $_POST['category_creation_id'];
}
if (isset($_POST['category_creation_name'])) {
    $category_creation_name = $_POST['category_creation_name'];
}

$crsNme='';
$crsStatus='';
$selectCategory=$con->query("SELECT * FROM category_creation WHERE category_creation_name = '".$category_creation_name."' ");
while ($row=$selectCategory->fetch_assoc()){
	$crsNme    = $row["category_creation_name"];
	$crsStatus  = $row["status"];
}

if($crsNme != '' && $crsStatus == 0){
	$message="Category Already Exists, Please Enter a Different Name!";
}
else if($crsNme != '' && $crsStatus == 1){
	$updateCategory=$con->query("UPDATE category_creation SET status=0 WHERE category_creation_name='".$category_creation_name."' ");
	$message="Category Added Succesfully";
}
else{
	if($category_creation_id>0){
		$updateCategory=$con->query("UPDATE category_creation SET category_creation_name='".$category_creation_name."' WHERE category_creation_id='".$category_creation_id."' ");
		if($updateCategory == true){
		    $message="Category Updated Succesfully";
	    }
    }
	else{
	    $insertCategory=$con->query("INSERT INTO category_creation(category_creation_name) VALUES('".strip_tags($category_creation_name)."')");
	    if($insertCategory == true){
		    $message="Category Added Succesfully";
	    }
    }
}

echo json_encode($message);
?>