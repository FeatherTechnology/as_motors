<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

function getDepartmentName($con, $department_id){
    $department_name='';
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($department_id)."' and status = 0";
    $res = $con->query($getqry);
    while($row = $res->fetch_assoc())
    {
       $department_name = $row["department_name"];        
    }
    return $department_name;
}

function getAssetClassificationName($assetClassification){
    $asset_classification='';
    if($assetClassification == "1"){$asset_classification = "Plant & Machinary";}
    if($assetClassification == "2"){$asset_classification = "Land & Building";}
    if($assetClassification == "3"){$asset_classification = "Computer";}
    if($assetClassification == "4"){$asset_classification = "Printer and Scanner";}
    if($assetClassification == "5"){$asset_classification = "Furniture and Fixtures";}
    if($assetClassification == "6"){$asset_classification = "Electrical & fitting";}

    return $asset_classification;
}

$department_id = array();
$department_name = array();
$asset_id  =  array();
$asset_name =  array();
$asset_classification =  array();

// get staff and department
$getName=$con->query("SELECT * FROM staff_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row2=$getName->fetch_assoc()){
    $staff_id[]    = $row2["staff_id"];
    $staff_name[]    = $row2["staff_name"];
    $department_name[]    = getDepartmentName($con, $row2["department"]);
} 

// get asset name and asset classification
$getName1=$con->query("SELECT * FROM asset_register WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row3=$getName1->fetch_assoc()){
    $asset_id[]    = $row3["asset_id"];
    $asset_name[]    = $row3["asset_name"];
    $asset_classification[]    = getAssetClassificationName($row3["asset_classification"]);
} 

$staffDeptDetails["staff_id"] = $staff_id;
$staffDeptDetails["staff_name"] = $staff_name;
$staffDeptDetails["department_name"] = $department_name;
$staffDeptDetails["asset_id"] = $asset_id;
$staffDeptDetails["asset_name"] = $asset_name;
$staffDeptDetails["asset_classification"] = $asset_classification;

echo json_encode($staffDeptDetails);
?>