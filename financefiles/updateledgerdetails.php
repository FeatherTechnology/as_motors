<?php

include '../ajaxconfig.php';
$eexciseduty=$eaddress1=$epan=$eaddress2=$etin=$eaddress3=$eservicetax=$eaddress4=$econtactperson=$econtactnumber="";
  if(isset($_POST["ledgerid"])){
    $ledgerid=$_POST["ledgerid"];
  }
  if(isset($_POST["eledgername"])){
    $eledgername=$_POST["eledgername"];
  }
  if(isset($_POST["eledgergroup"])){
    $eledgergroup=$_POST["eledgergroup"];
  }
  if(isset($_POST["eledgersubgroup"])){
    $eledgersubgroup=$_POST["eledgersubgroup"];
  }
  if(isset($_POST["eledgercostcentre"])){
    $eledgercostcentre=$_POST["eledgercostcentre"];
  }
  if(isset($_POST["einventory"])){
    $einventory=$_POST["einventory"];
  }

  if(isset($_POST["eexciseduty"])){
    $eexciseduty=$_POST["eexciseduty"];
  }
  if(isset($_POST["epan"])){
    $epan=$_POST["epan"];
  }
  if(isset($_POST["etin"])){
    $etin=$_POST["etin"];
  }
  if(isset($_POST["eservicetax"])){
    $eservicetax=$_POST["eservicetax"];
  }
  if(isset($_POST["econtactperson"])){
    $econtactperson=$_POST["econtactperson"];
  }
  if(isset($_POST["econtactnumber"])){
    $econtactnumber=$_POST["econtactnumber"];
  }
  if(isset($_POST["eaddress1"])){
    $eaddress1=$_POST["eaddress1"];
  }
  if(isset($_POST["eaddress2"])){
    $eaddress2=$_POST["eaddress2"];
  }
  if(isset($_POST["eaddress3"])){
    $eaddress3=$_POST["eaddress3"];
  }
  if(isset($_POST["eaddress4"])){
    $eaddress4=$_POST["eaddress4"];
  }
  $eopeningbalance = 0;
  if(isset($_POST["eopeningbalance"])){
    $eopeningbalance=$_POST["eopeningbalance"];
  }

  if(isset($_POST["openingbalancedr1"])){
    $openingbalancedr1=$_POST["openingbalancedr1"];
  }

  if($openingbalancedr1 == "CR"){
    $opening_credit = $eopeningbalance;
    $opening_debit  = 0;
  }else{
    $opening_credit = 0;
    $opening_debit  = $eopeningbalance;
    $eopeningbalance = -1*$eopeningbalance;
  }

  // $ledgerexists=$con->query("SELECT ledgername FROM ledger");
  // while($row=$ledgerexists->fetch_assoc()){
  //   $ledgerarray[]=$row["ledgername"];
  // }
  // if(in_array($eledgername, $ledgerarray)){
    // $ledgerupdate ="Ledger Already Exists!";
    $updateledgerqry="UPDATE ledger SET  AccountRefId = '".strip_tags($eledgersubgroup)."', ledgername = '".$eledgername."',
    inventory='".strip_tags($einventory)."',    costcentre='".strip_tags($eledgercostcentre)."',  exciseduty='".strip_tags($eexciseduty)."', pan='".strip_tags($epan)."',tin='".strip_tags($etin)."',servicetax='".strip_tags($eservicetax)."',contactnumber='".strip_tags($econtactnumber)."',contactperson='".strip_tags($econtactperson)."',address1='".strip_tags($eaddress1)."',address2='".strip_tags($eaddress2)."',address3='".strip_tags($eaddress3)."',address4='".strip_tags($eaddress4)."', opening_credit = '".$opening_credit."', opening_debit = '".$opening_debit."', openingbalancedr = '".$openingbalancedr1."', openingbalance = openingbalance + '".$eopeningbalance."' WHERE ledgerid='".strip_tags($ledgerid)."' ";
 
   $update=$con->query($updateledgerqry) or die("Error :".$con->error);
   $ledgerupdate ="Cost centre Has been Updated!";
   // }
  
echo json_encode($ledgerupdate);
?> 