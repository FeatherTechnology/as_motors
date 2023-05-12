<?php
include('../ajaxconfig.php');

if(isset($_POST["purposeid"])){
	$purposeid  = $_POST["purposeid"];
}
 $getdesig = "SELECT * FROM purpose WHERE purposeid = '".$purposeid."' and status=0";
 $result = $con->query($getdesig);
 while($row=$result->fetch_assoc())
 {
 $purposename = $row['purposename'];
 }
 echo $purposename;
?>