<?php
include('ajaxconfig.php');
if(isset($_POST["id"])){
	$id  = $_POST["id"];
}
$select1 = $con->query("SELECT year_id,year FROM year_creation WHERE year_id='$id'");
while($row=$select1->fetch_assoc()){
    $data['year_id']= $row["year_id"];
    $data['year']= $row["year"];
}



echo json_encode($data);

?>