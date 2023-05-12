<?php
$AccountsName="";
include '../ajaxconfig.php';
if(isset($_POST["ledgersubgroup"])){

	
$ledgersubgroup=$_POST["ledgersubgroup"];

$getqry="SELECT ParentId,AccountsName FROM accountsgroup WHERE Id='".strip_tags($ledgersubgroup)."' and status=0";
$res=$con->query($getqry);
while ($row=$res->fetch_assoc()){	
	$ParentId           = $row["ParentId"];
	$AccountsName       = $row["AccountsName"];
	if(	$ParentId >0)
	{
		$getqry1="SELECT AccountsName FROM accountsgroup WHERE Id='".strip_tags($ParentId)."' and status=0";
		$res1=$con->query($getqry1);
		while ($row1=$res1->fetch_assoc()){	
			$AccountsName       = $row1["AccountsName"];
		}
	}
}

}
echo json_encode($AccountsName);
?>

