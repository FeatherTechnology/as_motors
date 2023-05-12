<?php
include("../ajaxconfig.php");

$subgroupname1 = '';
$dsub_subgroupname = '';
$sub_subgroupname = '';

if(isset($_POST["dgroupname"])){
    $dgroupname=$_POST["dgroupname"];
  }
  if(isset($_POST["dsubgroupname"])){
    $dsubgroupname=$_POST["dsubgroupname"];
  } 
  if(isset($_POST["dsub_subgroupname"])){
    $dsub_subgroupname=$_POST["dsub_subgroupname"];
  }

  $isdelgrparray[]=(1);
  $isdelete="SELECT subgroupname FROM ledger where subgroupname =$dsubgroupname";

  $isdelresult=$mysqli->query($isdelete);
  while($row=$isdelresult->fetch_assoc()){
    $subgroupname1 =$row["subgroupname"];
  }

  
  $isSub_delete = "SELECT subgroupname FROM ledger where subgroupname = '".$dsub_subgroupname."' ";
 
  $isSub_delresult = $mysqli->query($isSub_delete);
  while($rowSub=$isSub_delresult->fetch_assoc()){
    $sub_subgroupname =$rowSub["subgroupname"];
  }

  $isSub_delete = "SELECT ParentId FROM accountsgroup ";
 
  $isSub_delresult = $mysqli->query($isSub_delete);
  while($rowSub=$isSub_delresult->fetch_assoc()){
    $parentid =$rowSub["ParentId"];
  }
  
  if($dsubgroupname == 12 || $dsubgroupname == 40){
  if($sub_subgroupname!=""){
    $delsubgroup = "You Don't Have Rights To Delete This Sub Subgroup!";
  }
  elseif($dsub_subgroupname==""){
    if($parentid==12 || $parentid==40){
    $delsubgroup = "You Don't Have Rights To Delete This Subgroup!";
  }else{
   $deletedsubgrp = "UPDATE  accountsgroup SET status=1 WHERE Id = $dsubgroupname ";
   $delsubgrp = $mysqli->query($deletedsubgrp) or die("Error :".$mysqli->error);
  $delsubgroup = "Sub-Group Has Been Deleted!";
  }
    }
    else{
      $deletedsubgrp = "UPDATE  accountsgroup SET status=1 WHERE Id = $dsub_subgroupname ";
      $delsubgrp = $mysqli->query($deletedsubgrp) or die("Error :".$mysqli->error);
      $delsubgroup = "Sub Sub-Group Has Been Deleted!";
    }
  }
  else
  {
    $deletedsubgrp = "UPDATE  accountsgroup SET status=1 WHERE Id = $dsubgroupname ";
     $delsubgrp = $mysqli->query($deletedsubgrp) or die("Error :".$mysqli->error);
    $delsubgroup = "Sub-Group Has Been Deleted!";
  }

  echo json_encode($delsubgroup);
  ?>