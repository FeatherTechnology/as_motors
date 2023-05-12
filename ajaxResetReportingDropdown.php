<?php 
include('ajaxconfig.php');

if (isset($_POST['branch_id'])) {
   $company_id = $_POST['branch_id'];
}

$reportingArr = array();
$result=$con->query("SELECT * FROM basic_creation where company_id='".$company_id."' and status=0");
while( $row = $result->fetch_assoc()){
    $designation_id1[] = $row['designation'];
}

$reportingStr = implode(",", $designation_id1);
$reporting = array_map('intval', explode(',', $reportingStr)); 

// remove array duplicates without affect array index
$designation_id=$reporting;
$duplicated=array();

foreach($designation_id as $k=>$v) {

if( ($kt=array_search($v,$designation_id))!==false and $k!=$kt )
{ unset($designation_id[$kt]);  $duplicated[]=$v; }

}
sort($designation_id); // optional
// end here

for($i=0;$i<=sizeof($designation_id)-1;$i++){
    $result1=$con->query("SELECT * FROM designation_creation where designation_id='".$designation_id[$i]."' and status=0");
    while( $row1 = $result1->fetch_assoc()){
        $designation_name[] = $row1['designation_name'];
    }
}

$reportingArr['designation_id'] = $designation_id;
$reportingArr['designation_name'] = $designation_name;

echo json_encode($reportingArr);
?>