<?php
include '../ajaxconfig.php';
  if(isset($_POST["costcentrenewname"])){
    $costcentrenewname=$_POST["costcentrenewname"];
  }
  if(isset($_POST["costcentreid"])){
    $costcentreid=$_POST["costcentreid"];
  }

$selectexist=$con->query("SELECT costcentrename FROM costcentre") or die("Error".$mysqli->error);
while ($row=$selectexist->fetch_assoc()) {
  $costcentreexist[]=$row["costcentrename"];
}
if(in_array($costcentrenewname, $costcentreexist))
{
$costcentreupdate="CostCenter Already Exists, Enter Different Name!";
}
else
{
$updatecentre="UPDATE costcentre SET costcentrename = '".strip_tags($costcentrenewname)."' WHERE costcentreid = '".strip_tags($costcentreid)."' ";
$updatecostcentre=$con->query($updatecentre) or die("Error :".$con->error);
$costcentreupdate="Cost centre Has been Updated!";
}
echo json_encode($costcentreupdate);
?>