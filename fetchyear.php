<?php
include('ajaxconfig.php');
if(isset($_POST["insertedcompany"])){
	$insertedcompany  = $_POST["insertedcompany"];
}

$year_id = array();
$year = array();
$prevyear = array();

$qry1=$con->query("SELECT year_id,year FROM year_creation  WHERE company_id = '$insertedcompany'");

while($row1=$qry1->fetch_assoc()){
    $year_id[] = $row1['year_id'];
    $year[] = $row1['year'];
}

for($i=0;$i<count($year_id); $i++){
    $prevyear[$i]['year_id'] = $year_id[$i];
    $prevyear[$i]['year'] = $year[$i];
}

echo json_encode($prevyear);
?>