<?php 
// 4 - Director....the employee can be in any company or branch but they can report to main branch manager or the manager who reporting to MD. so we assign director designation id static, if director designation change here also change it.

include('ajaxconfig.php');

if (isset($_POST['branch_id'])) {
    $company_id = $_POST['branch_id'];
}

$reportingArr = array();
$designation_id1 = array();
$result=$con->query("SELECT * FROM basic_creation where company_id='".$company_id."' and status=0");
while( $row = $result->fetch_assoc()){
    $designation_id1[] = $row['designation'];
}

$reportingStr = implode(",", $designation_id1);
if($reportingStr !=''){
    $reporting = array_map('intval', explode(',', $reportingStr)); 
}else{
    $reporting = array();
}
// remove array duplicates without affect array index
$designation_id=$reporting;
$duplicated=array();

foreach($designation_id as $k=>$v) {

if( ($kt=array_search($v,$designation_id))!==false and $k!=$kt )
{ unset($designation_id[$kt]);  $duplicated[]=$v; }

}
sort($designation_id); // After unset a array the key will be miss so have to sort the array for key arrange.

$designation_name = array();
for($i=0; $i <= count($designation_id); $i++){
    $desgnCreationQry=$con->query("SELECT * FROM designation_creation where designation_id='".$designation_id[$i]."' and status=0");
    if(mysqli_num_rows($desgnCreationQry) > 0 ){
        $row1 = $desgnCreationQry->fetch_assoc();
        $designation_name[] = $row1['designation_name'];

    }else{
        unset($designation_id[$i]);
    }
}

sort($designation_id); // After unset a array the key will be miss so have to sort the array for key arrange.

$reportingArr['designation_id'] = $designation_id;
$reportingArr['designation_name'] = $designation_name;


$managerLevelQry = $con->query("SELECT * FROM basic_creation where report_to = '4' and company_id !='".$company_id."' and status=0"); // 4 - Director....the employee can be in any company or branch but they can report to main branch manager or the manager who reporting to MD. so we assign director designation id static, if director designation change here also change it.  
$design_id = array();
while( $managerLevelInfo = $managerLevelQry->fetch_assoc()){
    $design_id[] = $managerLevelInfo['designation'];
}

$reportStr = implode(",", $design_id);
$report = array_map('intval', explode(',', $reportStr)); 

// remove array duplicates without affect array index
$desgn_id=$report;
$duplicat=array();

foreach($desgn_id as $k=>$v) {

if( ($kt=array_search($v,$desgn_id))!==false and $k!=$kt )
{ unset($desgn_id[$kt]);  $duplicat[]=$v; }

}
sort($desgn_id); // After unset a array the key will be miss so have to sort the array for key arrange.

for($i=0;$i<=sizeof($desgn_id)-1;$i++){
    $result1=$con->query("SELECT * FROM designation_creation where designation_id='".$desgn_id[$i]."' and status=0");
    if(mysqli_num_rows($result1) > 0 ){
        $row1 = $result1->fetch_assoc();
        array_push($reportingArr['designation_id'], $desgn_id[$i]);
        array_push($reportingArr['designation_name'], $row1['designation_name']);
    }

}


echo json_encode($reportingArr);
?>