<?php 
include('../ajaxconfig.php');

if(isset($_POST["esubgroupname"])){
	$esubgroupname = $_POST["esubgroupname"];
}

$subgrparr = array();
$result=$con->query("SELECT * FROM accountsgroup WHERE ParentId='".strip_tags($esubgroupname)."' and status=0");
while( $row = $result->fetch_assoc()){
      $Id           = $row['Id'];
      $AccountsName = $row['AccountsName'];
      $subgrparr[]  = array("Id" => $Id, "AccountsName" => $AccountsName);
   }
echo json_encode($subgrparr);
?>