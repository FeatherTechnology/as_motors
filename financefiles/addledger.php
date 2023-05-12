<?php
 @session_start();
include '../ajaxconfig.php';

$exciseduty=$address1=$pan=$address2=$tin=$address3=$servicetax=$address4=$contactperson=$contactnumber="";
if(isset($_POST["ledgername"])){
	$ledgername=$_POST["ledgername"];
}
if(isset($_POST["ledgergroup"])){
	$ledgergroup=$_POST["ledgergroup"];
}
if(isset($_POST["ledgersubgroup"])){
	$ledgersubgroup=$_POST["ledgersubgroup"];
}
if(isset($_POST["ledgercostcentre"])){
	$ledgercostcentre=$_POST["ledgercostcentre"];
}
if(isset($_POST["inventory"])){
	$inventory=$_POST["inventory"];
}

if(isset($_POST["exciseduty"])){
	$exciseduty=$_POST["exciseduty"];
}
if(isset($_POST["address1"])){
	$address1=$_POST["address1"];
}
if(isset($_POST["pan"])){
	$pan=$_POST["pan"];
}
if(isset($_POST["address2"])){
	$address2=$_POST["address2"];
}
if(isset($_POST["tin"])){
	$tin=$_POST["tin"];
}
if(isset($_POST["address3"])){
	$address3=$_POST["address3"];
}
if(isset($_POST["servicetax"])){
	$servicetax=$_POST["servicetax"];
}
if(isset($_POST["address4"])){
	$address4=$_POST["address4"];
}
if(isset($_POST["contactperson"])){
	$contactperson=$_POST["contactperson"];
}
if(isset($_POST["contactnumber"])){
	$contactnumber=$_POST["contactnumber"];
}
if(isset($_POST["openingbalance"])){
	$openingbalance=$_POST["openingbalance"];
}
if(isset($_POST["openingbalancedr"])){
	$openingbalancedr = $_POST["openingbalancedr"];
}
if($openingbalancedr == "CR"){
	$opening_credit = $openingbalance;
	$opening_debit  = 0;
}else{
	$opening_debit  = $openingbalance;
	$opening_credit = 0;
	$openingbalance = -1*$openingbalance;
}



$accountsId="";

$ledgers[]=(1);
$isadd="SELECT ledgername FROM ledger";
$res=$con->query($isadd);
while($row=$res->fetch_assoc()){
	$ledgers[]=$row["ledgername"];
}
if(in_array($ledgername, $ledgers)){
	$ledgerinsert="Ledger Already Exists, Please Enter a Different Name!";
}else{

	$isadd="SELECT * FROM accountsgroup where AccountsName='".strip_tags($ledgergroup)."' ";
	$res=$con->query($isadd);
	while($row=$res->fetch_assoc()){
		$accountsId =$row["Id"];
	}

	$insertqry="INSERT INTO ledger(ledgername, groupname, subgroupname, costcentre, openingbalancedr, opening_credit, opening_debit, 	openingbalance, inventory, exciseduty, address1, pan, address2, tin, address3, servicetax, address4, contactperson, contactnumber, AccountRefId) 
	VALUES('".strip_tags($ledgername)."', '".strip_tags($accountsId)."', '".strip_tags($ledgersubgroup)."', '".strip_tags($ledgercostcentre)."', '".strip_tags($openingbalancedr)."' ,'".strip_tags($opening_credit)."' ,'".strip_tags($opening_debit)."' , '".strip_tags($openingbalance)."', '".strip_tags($inventory)."', '".strip_tags($exciseduty)."', '".strip_tags($address1)."', '".strip_tags($pan)."', '".strip_tags($address2)."', '".strip_tags($tin)."', '".strip_tags($address3)."', '".strip_tags($servicetax)."', '".strip_tags($address4)."', '".strip_tags($contactperson)."', '".strip_tags($contactnumber)."', '".strip_tags($ledgersubgroup)."' )";
	$insresult=$con->query($insertqry) or die($con->error);
	$ledgerinsert="Ledger Added Succesfully!";
}
echo json_encode($ledgerinsert);
?>