<?php
include("../ajaxconfig.php");

$subgroupname1="";
if(isset($_POST["egroupid"])){
  $egroupid = $_POST["egroupid"];
}
if(isset($_POST["egroupname"])){
  $egroupname = $_POST["egroupname"];
}
if(isset($_POST["newsubgroupname"])){
  $newsubgroupname = $_POST["newsubgroupname"];
}
if(isset($_POST["esubgroupstatus"])){
  $esubgroupstatus = $_POST["esubgroupstatus"];
}
if(isset($_POST["esubgroupname"])){
  $esubgroupname = $_POST["esubgroupname"];
}
if(isset($_POST["esub_subgroupname"])){
  $esub_subgroupname = $_POST["esub_subgroupname"];
} 
if(isset($_POST["newsub_subgroupname"])){
  $newsub_subgroupname = $_POST["newsub_subgroupname"];
}
  

$grouparray[]=(1);
 
$isduplicate = "SELECT AccountsName FROM accountsgroup WHERE AccountsName = '".strip_tags($newsubgroupname)."' and ParentId = $egroupname and status = 0 ";

$isduplicateresult = $mysqli->query($isduplicate);
while($row = $isduplicateresult->fetch_assoc()){
  $subgroupname1 = $row["AccountsName"];
}


if($esubgroupname == 12 || $esubgroupname == 40){
  if($subgroupname1 != ""){
     $updateresult = "Sub-group Already Exists, Please Enter a Different Name!";
   }else{
     $updategrp = "UPDATE accountsgroup SET AccountsName='".strip_tags($newsubgroupname)."' WHERE Id=$esubgroupname ";
     $updategrp = "UPDATE accountsgroup SET AccountsName='".strip_tags($newsub_subgroupname)."' WHERE Id=$esub_subgroupname ";
     $updated = $mysqli->query($updategrp) or die("Error :".$mysqli->error);
     $updateresult = "Sub-group Has been Updated!";
  }
}else{
   if($subgroupname1 != ""){
     $updateresult = "Sub-group Already Exists, Please Enter a Different Name!";
   }else{
     $updategrp = "UPDATE accountsgroup SET AccountsName='".strip_tags($newsubgroupname)."' WHERE Id=$esubgroupname ";
     $updated = $mysqli->query($updategrp) or die("Error :".$mysqli->error);
     $updateresult = "Sub-group Has been Updated!";
   }
}
echo json_encode($updateresult);

?>