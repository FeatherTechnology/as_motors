<?php 
include('../ajaxconfig.php');

if(isset($_POST["groupname"])){
	$groupname = $_POST["groupname"];
}

$subgrparr = array();
$result=$con->query("SELECT * FROM accountsgroup WHERE ParentId='".strip_tags($groupname)."' and status=0");
while( $row = $result->fetch_assoc()){
      $Id           = $row['Id'];
      $AccountsName = $row['AccountsName'];
      $subgrparr[]  = array("Id" => $Id, "AccountsName" => $AccountsName);
   }
echo json_encode($subgrparr);
?>