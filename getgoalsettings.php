<?php
include('ajaxconfig.php');

if(isset($_POST["prev_company"])){
	$company_id  = $_POST["prev_company"];
}

$department_id = array();
$department_name = array();

$branch_id = array();
$hierarchyArr = array();
$hierarchyDep = array();
$department_id = array();
$department_name = array();

// fetch branch id
$qry = "SELECT * FROM branch_creation WHERE company_id = '".$company_id."' AND status=0"; 
$res = $con->query($qry);
while($row = $res->fetch_assoc())
{
    $branch_id[] = $row['branch_id'];
}

// get department
for($j=0; $j<=sizeof($branch_id)-1; $j++){
    
    $getDepartmentId = $con->query("SELECT * FROM basic_creation WHERE company_id ='".strip_tags($branch_id[$j])."' AND status = 0 ");
    while($row1=$getDepartmentId->fetch_assoc()){
        $hierarchyArr[]    = $row1["department"];
    }
} 

// remove array duplicates without affect array index
$hierarchyDep=$hierarchyArr;
$duplicated=array();

foreach($hierarchyDep as $k=>$v) {

    if( ($kt=array_search($v,$hierarchyDep))!==false and $k!=$kt )
    { unset($hierarchyDep[$kt]);  $duplicated[]=$v; }
}

sort($hierarchyDep);

for($i=0; $i<=sizeof($hierarchyDep)-1; $i++){
    
    $qry=$con->query("SELECT department_id,department_name FROM department_creation  WHERE  department_id ='".strip_tags($hierarchyDep[$i])."' AND status = 0");
    while($row=$qry->fetch_assoc()){
        $department_id[] = $row['department_id'];
        $department_name[] = $row['department_name'];
    }
}

for($i=0;$i<count($department_id); $i++){
    $prevChecklist[$i]['department_id'] = $department_id[$i];
    $prevChecklist[$i]['department_name'] = $department_name[$i];
}

echo json_encode($prevChecklist);

?>