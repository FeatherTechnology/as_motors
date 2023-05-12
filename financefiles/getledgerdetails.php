<?php
include '../ajaxconfig.php';

if(isset($_POST["selectledger"])){
	$selectledger=$_POST["selectledger"];
}

$ledgerdetails=array();
$getqry="SELECT * FROM ledger WHERE ledgername='".strip_tags($selectledger)."' ";
$res=$con->query($getqry);
while ($row=$res->fetch_assoc()){
	$ledgerdetails["ledgerid"] = $row["ledgerid"];
	$ledgerdetails["eledgername"] = $row["ledgername"];

	$ledgerdetails["einventory"] = $row["inventory"];
	$ledgerdetails["eledgercostcentre"] = $row["costcentre"];
	$ledgerdetails["eledgerstatus"] = $row["status"];
	
	$ledgerdetails["OpeningBalance"] = $row["openingbalance"];
	$ledgerdetails["exciseduty"]     = $row["exciseduty"];
	$ledgerdetails["pan"]            = $row["pan"];
	$ledgerdetails["tin"]            = $row["tin"];
	$ledgerdetails["servicetax"]     = $row["servicetax"];
	$ledgerdetails["contactperson"]  = $row["contactperson"];
	$ledgerdetails["contactnumber"]  = $row["contactnumber"];
	$ledgerdetails["address1"]       = $row["address1"];
	$ledgerdetails["address2"]       = $row["address2"];
	$ledgerdetails["address3"]       = $row["address3"];
	$ledgerdetails["address4"]       = $row["address4"];

	$AccountRefId                    = $row["AccountRefId"];
	

	$getqry1="SELECT * FROM accountsgroup WHERE Id='".strip_tags($AccountRefId)."' ";
	$res1=$con->query($getqry1);
	while ($row1=$res1->fetch_assoc()){
		$ledgerdetails["eledgersubgroupname"] = $row1["AccountsName"];
		$ledgerdetails["eledgergroupname"] = $row1["AccountsName"];
		$ParentId              = $row1["ParentId"];

		

	if(	$ParentId >0)
	{
		$getqry2="SELECT * FROM accountsgroup WHERE Id='".strip_tags($ParentId)."' ";
	$res2=$con->query($getqry2);
	while ($row2=$res2->fetch_assoc()){
		$ledgerdetails["eledgergroupname"] = $row2["AccountsName"];
	
		$ParentId              = $row2["ParentId"];
	}
	}
	}
}
echo json_encode($ledgerdetails);
?>
