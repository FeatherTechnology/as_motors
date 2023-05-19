<?php
include('ajaxconfig.php');

if(isset($_POST["insertedyear"])){
	$insertedyear  = $_POST["insertedyear"];
}
if(isset($_POST["insertedcompany"])){
	$insertedcompany  = $_POST["insertedcompany"];

}
        $qry="INSERT INTO year_creation (year_id,year,company_id, status)
				VALUES (NULL,'$insertedyear', '$insertedcompany', '0')";
				$insert_assign=$mysqli->query($qry) or die("Error ".$mysqli->error);
				
                return $insert_assign;


?>