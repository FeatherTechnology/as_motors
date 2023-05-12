<?php
include '../ajaxconfig.php';

if(isset($_POST["category_creation_id"])){
	$category_creation_id  = $_POST["category_creation_id"];
}

$getct = "SELECT * FROM category_creation WHERE category_creation_id = '".$category_creation_id."' AND status=0";
$result = $con->query($getct);
while($row=$result->fetch_assoc())
{
    $category_creation_name = $row['category_creation_name'];
}

echo $category_creation_name;
?>