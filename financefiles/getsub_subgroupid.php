<?php 
include('../ajaxconfig.php');

if(isset($_POST["esubgroupname"])){
	$esubgroupname = $_POST["esubgroupname"];
}
if(isset($_POST["esub_subgroupname"])){
	$esub_subgroupname = $_POST["esub_subgroupname"];
}
$subgrouparr = array();
$result=$con->query("SELECT * FROM subgroup WHERE groupname='".strip_tags($esubgroupname)."' AND  subgroupname='".strip_tags($esub_subgroupname)."' ");
while( $row = $result->fetch_assoc()){
      $subgrouparr["groupid"]= $row['groupid'];
      $subgrouparr["subgroupname"] = $row['subgroupname'];
      $subgrouparr["status"] =$row["status"];
   }
echo json_encode($subgrouparr);
?>