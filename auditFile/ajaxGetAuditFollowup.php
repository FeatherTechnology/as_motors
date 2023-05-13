<?php
include '../ajaxconfig.php';

if(isset($_POST["checklist"])){
	$prev_chekclist_id  = $_POST["checklist"];
  
   
}
if(isset($_POST["date"])){
	$current_date  = $_POST["date"];
    
}

$audit_assign_id = array();
$department_id = array();
$role1 = array();
$dcrole1 = array();
$role2 = array();
$dcrole2 = array();
$department_name= array();



$qry=$con->query("SELECT a.audit_assign_id, a.department_id, a.role1, dc1.designation_name AS dcrole1, a.role2, GROUP_CONCAT(DISTINCT dc2.designation_name) AS dcrole2
FROM audit_assign a
LEFT JOIN designation_creation dc1 ON dc1.designation_id = a.role1
LEFT JOIN designation_creation dc2 ON dc2.designation_id = a.role2
LEFT JOIN audit_assign_ref aai ON aai.audit_assign_id = a.audit_assign_id
WHERE a.audit_area_id = '$prev_chekclist_id'
  AND aai.target_date <= CURDATE() + INTERVAL 3 DAY
GROUP BY a.audit_assign_id, a.department_id, a.role1, dc1.designation_name, a.role2");

while($row=$qry->fetch_assoc()){
 
    $audit_assign_id[] = $row['audit_assign_id'];
    $department_id[]= $row['department_id'];
   
    $role1[]= $row['role1'];
    $dcrole1[] = $row['dcrole1'];
    $role2[]= $row['role2']; 
    $dcrole2[] = $row['dcrole2'];
    
   
}


for($i=0;$i<count($audit_assign_id); $i++){
    $Checklist[$i]['audit_assign_id'] = $audit_assign_id[$i];
    $Checklist[$i]['department_id'] = $department_id[$i];
    $Checklist[$i]['role1'] = $role1[$i];
    $Checklist[$i]['dcrole1'] = $dcrole1[$i];
    $Checklist[$i]['role2'] = $role2[$i];
    $Checklist[$i]['dcrole2'] = $dcrole2[$i];
   
}

foreach($department_id as $departmentid) {
$deptid = trim($departmentid);
$department_name1 = "SELECT GROUP_CONCAT(department_name) AS department_name FROM department_creation WHERE department_id IN ($deptid) ";
    
$res2 = $mysqli->query($department_name1);


          $row2 = $res2->fetch_assoc();
          $department_name = $row2['department_name'];



}
$Checklist['department_name']                 = $department_name;





echo json_encode($Checklist);

?>