<?php
include('ajaxconfig.php');

if(isset($_POST["prevyear"])){
    $prevyear  = $_POST["prevyear"];
    

}

$qry1=$con->query("SELECT gs.year AS year_id,y.year AS pyear FROM goal_setting gs LEFT JOIN year_creation y ON y.year_id = gs.year WHERE y.year = '$prevyear'");
$row1=$qry1->fetch_assoc();
if($row1 == ''){
    $year_id ="";
    $pyear = "";
   
}else{
    $year_id = $row1['year_id'];
    $pyear = $row1['pyear'];
}

    $message['year_id'] = $year_id;    
    $message['pyear'] = $pyear;

echo json_encode($message);
?>