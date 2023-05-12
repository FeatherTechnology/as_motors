<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"]; 
}

$department_id = array();
$department_name = array();
$asset_id  =  array();
$asset_name =  array();
$asset_classification =  array();

$designation_name = array();
$designation_id = array();
$designation = array();

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

// get asset name and asset classification
$getName1=$con->query("SELECT * FROM asset_register WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row3=$getName1->fetch_assoc()){
    $asset_id[]    = $row3["asset_id"];
    $asset_name[]    = $row3["asset_name"];
    $asset_classification[]    = getAssetClassificationName($row3["asset_classification"]);
} 

$designationDetails["asset_id"] = $asset_id;
$designationDetails["asset_name"] = $asset_name;
$designationDetails["asset_classification"] = $asset_classification;

// get designation based on hierarchy
$getDesignationId = $con->query("SELECT * FROM basic_creation WHERE status = 0 AND company_id ='".strip_tags($company_id)."' ");
while($row1=$getDesignationId->fetch_assoc()){
    $designation[]    = $row1["designation"]; 
}

$designationStr = implode(",", $designation);
$designation = array_map('intval', explode(',', $designationStr)); 

// remove array duplicates without affect array index
$hierarchyDep=$designation;
$duplicated=array();
foreach($hierarchyDep as $k=>$v) {
    if( ($kt=array_search($v,$hierarchyDep))!==false and $k!=$kt )
    { unset($hierarchyDep[$kt]);  $duplicated[]=$v; }
}
sort($hierarchyDep); // optional

for($i=0; $i<=sizeof($hierarchyDep)-1; $i++){
    $getqry =  $con->query("SELECT designation_name, designation_id FROM designation_creation WHERE designation_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0"); 
    while($row2 = $getqry->fetch_assoc()){
        $designation_id[]= $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];       
    }
} 

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name; 

echo json_encode($designationDetails);
?>