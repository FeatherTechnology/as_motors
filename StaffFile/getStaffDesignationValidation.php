<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"]; 
}
$designationEdit = '';
if(isset($_POST["designationEdit"])){
	$designationEdit = $_POST["designationEdit"]; 
}

$designation_name = array();
$designation_id = array();

// get department based designation
$getDesignationId=$con->query("SELECT designation FROM basic_creation WHERE status = 0 AND FIND_IN_SET($department_id, department) > 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row2=$getDesignationId->fetch_assoc()){
    $designation1[]    = $row2["designation"]; 
}  
$designationStr = implode(",", $designation1);
$designationArr = array_map('intval', explode(',', $designationStr));

// remove array duplicates without affect array index
$designation=$designationArr;
$duplicated=array();

foreach($designation as $k=>$v) {

    if( ($kt=array_search($v,$designation))!==false and $k!=$kt )
    { unset($designation[$kt]);  $duplicated[]=$v; }

}
sort($designation); // optional
// end here

for($i=0; $i<=sizeof($designation)-1; $i++){

    $staffqry =$con->query("SELECT * FROM staff_creation sc WHERE sc.designation = '".strip_tags($designation[$i])."' AND sc.status = 0 ");
    if(mysqli_num_rows($staffqry) <= 0){
        
        $getqry = "SELECT dc.designation_name, dc.designation_id FROM designation_creation dc WHERE dc.designation_id ='".strip_tags($designation[$i])."' AND dc.status = 0 "; 
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc()){
            $designation_id[] = $row12["designation_id"];        
            $designation_name[] = $row12["designation_name"];       
        }  
        
    }   
}  

$geteditdesgn = "SELECT dc.designation_name, dc.designation_id FROM designation_creation dc WHERE dc.designation_id ='$designationEdit' AND dc.status = 0 "; 
$desgnDetails = $con->query($geteditdesgn);
while($desgninfo = $desgnDetails->fetch_assoc()){
    $designation_id[] = $desgninfo["designation_id"];        
    $designation_name[] = $desgninfo["designation_name"];       
} 

$designationDetails["designation_id"] = $designation_id;
$designationDetails["designation_name"] = $designation_name; 

echo json_encode($designationDetails);
?>