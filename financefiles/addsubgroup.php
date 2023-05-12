<?php
@session_start();
include("../ajaxconfig.php");

$subgroupname1="";
if(isset($_POST["groupname"])){
    $groupname = $_POST["groupname"];
  }
if(isset($_POST["subgroupname"])){
  $subgroupname = $_POST["subgroupname"];
}
if(isset($_POST["esubgroupname1"])){
  $esubgroupname1 = $_POST["esubgroupname1"];
} 

  
$grouparray[]=(1);
$isduplicate="SELECT AccountsName FROM accountsgroup WHERE AccountsName = '".strip_tags($subgroupname)."' and ParentId=$groupname and status=0  ";

$isdupresult=$con->query($isduplicate);
  while ($row=$isdupresult->fetch_assoc()) {
    $subgroupname1 = $row["AccountsName"];
}

if($esubgroupname1 == 12 || $esubgroupname1 == 40){
  if($subgroupname1 != ""){
     $insresult="Sub-group Already Exists, Please Enter a Different Name!";
  }else{
      $insertgrp = "INSERT INTO accountsgroup(AccountsName, ParentId) VALUES ('".strip_tags($subgroupname)."',  '".strip_tags($esubgroupname1)."') ";

      $insresult=$con->query($insertgrp) or die("Error :".$con->error);
      $insresult="Subgroup Added Succesfully!";
  }
}else{
  if($subgroupname1 != ""){
     $insresult="Sub-group Already Exists, Please Enter a Different Name!";
  }else{
      $insertgrp = "INSERT INTO accountsgroup(AccountsName, ParentId) VALUES ('".strip_tags($subgroupname)."',  '".strip_tags($groupname)."') ";

      $insresult=$con->query($insertgrp) or die("Error :".$con->error);
      $insresult="Subgroup Added Succesfully!";
  }
}

echo json_encode($insresult);
?>