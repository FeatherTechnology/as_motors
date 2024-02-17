<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["branch_id"])){
    $company_id = $_POST["branch_id"];
} 
if(isset($_POST["basic_creation_id"])){
    $basic_creation_id = $_POST["basic_creation_id"];
} 

$designationArr = array();
$designation_id = array();
$designation_name = array();

// get designation based on hierarchy cration
$getDepartmentId = $con->query("SELECT * FROM basic_creation WHERE basic_creation_id ='".strip_tags($basic_creation_id)."' ");

while($row1=$getDepartmentId->fetch_assoc()){
    $designationArr[]    = $row1["designation"];
    
}

$designationStr = implode(",", $designationArr);
$designation = array_map('intval', explode(',', $designationStr)); 

// remove array duplicates without affect array index
$designationId=$designation;
$duplicated=array();

foreach($designationId as $k=>$v) {

    if( ($kt=array_search($v,$designationId))!==false and $k!=$kt )
    { unset($designationId[$kt]);  $duplicated[]=$v; }
}

sort($designationId); // optional
$getDesignationName = $con->query("SELECT * FROM designation_creation  WHERE company_id = '$company_id' and status = '0' ");

// for($i=0; $i<=sizeof($getDesignationName)-1; $i++){  
    // print_r($designationId);
    
        //  WHERE designation_id IN ($designationId[$i])
        // $getDesignationName = $con->query("SELECT * FROM designation_creation WHERE designation_id NOT IN ($designationId[$i])");
   
    while($row2 = $getDesignationName->fetch_assoc()){
        
        $designation_id[] = $row2["designation_id"];        
        $designation_name[] = $row2["designation_name"];  
       

        
    } 
          

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name;

echo json_encode($designationDetails);
?>