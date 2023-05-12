 <?php
 @session_start();
 include '../ajaxconfig.php';

if(isset($_POST["costcentrename"])){
  $costcentrename = $_POST["costcentrename"];
}

$costcentrearray[]=(1);
$centre = "SELECT costcentrename FROM costcentre"; 
$ispresent=$con->query($centre);
while ($row=$ispresent->fetch_assoc()){
  $costcentrearray[]=$row["costcentrename"];
}
if(in_array($costcentrename, $costcentrearray)){
  $cosrcentreres= "Cost Cender Already Exists, Please Enter a Different Name!";
}else{
  $insertcentre="INSERT INTO costcentre(costcentrename) VALUES('".strip_tags($costcentrename)."') ";
  $insertcostcentre=$con->query($insertcentre) or die("Error :".$con->error);
  $cosrcentreres= "Cost Cender Added Succesfully";
}

echo json_encode($cosrcentreres);
?>