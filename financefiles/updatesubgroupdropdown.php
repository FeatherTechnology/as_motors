<?php
include '../ajaxconfig.php';

$getsubgroup=$con->query("SELECT Id,AccountsName FROM accountsgroup WHERE status=0  ORDER BY AccountsName ASC") or die("Error :".$con->error);
$i=0;
while ($row=$getsubgroup->fetch_assoc()) {
	$subgrouparray[$i]["Id"]=$row["Id"];
	$subgrouparray[$i]["AccountsName"]=$row["AccountsName"];
	$i++;
}
echo json_encode($subgrouparray);
?>