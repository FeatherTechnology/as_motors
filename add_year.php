<?php
include('ajaxconfig.php');

if(isset($_POST["insertedyear"])){
	$insertedyear  = $_POST["insertedyear"];
}
if(isset($_POST["insertedcompany"])){
	$insertedcompany  = $_POST["insertedcompany"];

}
// $id= '';

if (isset($_POST["id"])) {
    $id = $_POST["id"];
} 


if (empty($_POST["id"])) {
    $qry = "INSERT INTO year_creation (year_id, year, company_id, status)
           VALUES (NULL, '$insertedyear', '$insertedcompany', '0')";
    $insert_assign = $mysqli->query($qry) or die("Error " . $mysqli->error);
	echo json_encode($insert_assign);

} else {
    $qry = "UPDATE year_creation y SET y.year = '$insertedyear' WHERE y.year_id = '$id' AND y.company_id = '$insertedcompany'";

    $insert_assign = $mysqli->query($qry) or die("Error " . $mysqli->error);
	echo json_encode($insert_assign);
}

?>