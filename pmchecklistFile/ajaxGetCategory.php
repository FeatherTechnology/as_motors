<?php 
include('../ajaxconfig.php');

$loan_category_arr = array();
$result=$con->query("SELECT * FROM category_creation where 1 and status=0");
while( $row = $result->fetch_assoc()){
    $category_creation_id = $row['category_creation_id'];
    $category_creation_name = $row['category_creation_name'];
    $loan_category_arr[] = array("category_creation_id" => $category_creation_id, "category_creation_name" => $category_creation_name);
}

echo json_encode($loan_category_arr);
?>