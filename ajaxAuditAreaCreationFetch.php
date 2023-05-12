<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 

$column = array(
    
    'audit_area_id',
    'audit_area',
    'department_id',
    'frequency',
    'calendar',
    'from_date',
    'to_date',
    'role1',
    'role2',
    'check_list',
    'status'
);

$query = "SELECT * FROM audit_area_creation WHERE 1";
if ($sbranch_id == 'Overall') {
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {
    
            if($_POST['search']=="Active")
            {
                $query .="and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .="and status=1 ";
            }
    
            else{	
                $query .= "
    
                OR audit_area_id LIKE '%".$_POST['search']."%'
                OR audit_area LIKE '%".$_POST['search']."%'
                OR department_id LIKE '%".$_POST['search']."%'
                OR frequency LIKE '%".$_POST['search']."%'
                OR calendar LIKE  '%".$_POST['search']."%'
                OR from_date LIKE  '%".$_POST['search']."%'
                OR to_date LIKE  '%".$_POST['search']."%'
                OR role1 LIKE  '%".$_POST['search']."%'
                OR role2 LIKE '%".$_POST['search']."%'
                OR check_list LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    
    $sdepartment_id = array();
    $branchQry = "SELECT department_creation.* FROM department_creation INNER JOIN audit_area_creation ON department_creation.department_id = audit_area_creation.department_id 
    WHERE audit_area_creation.status = 0 and department_creation.status = 0 and department_creation.company_id = '".$sbranch_id."' ";
    $branchRes = $con->query($branchQry);
    while($branchrow = $branchRes->fetch_assoc())
    {
        $branch_id[] = $branchrow["company_id"];      
        $sdepartment_id[] = $branchrow["department_id"];      
    }
        
    $query .=" and (";
    for ($l = 0; $l < count($sdepartment_id);$l++){
        $query .=" department_id= '".$sdepartment_id[$l]."' ";
        if ($l < count($sdepartment_id)-1) {
            $query .= " or";
        }        
    }
    $query .=" ) ";
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $connect->prepare($query . $query1);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

$sno = 1;
foreach ($result as $row) {
    $sub_array   = array();
    $department_name   = array();
  
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $departmentId1 = explode(",", $row['department_id']);
    foreach($departmentId1 as $departmentId) {
        $departmentId = trim($departmentId);
        $getqry1 = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentId)."' and status = 0";
        $res13 = $con->query($getqry1);
        while($row13 = $res13->fetch_assoc())
        {
           $department_name[] = $row13["department_name"];      
        }
    }

    $role1Name='';
    $role1Id = $row['role1'];   
    $getAuditorName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role1Id)."' and status = 0";
    $res12 = $con->query($getAuditorName);
    while($row12 = $res12->fetch_assoc())
    {
       $role1Name = $row12["designation_name"];        
    }
    
    $role2Name='';
    $role2Id = $row['role2'];   
    $getAuditeeName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role2Id)."' and status = 0";
    $res14 = $con->query($getAuditeeName);
    while($row14 = $res14->fetch_assoc())
    {
       $role2Name = $row14["designation_name"];        
    }

    $sub_array[] = $row['audit_area'];
    $sub_array[] = $department_name;
    $sub_array[] = $row['frequency'];
    $sub_array[] = $row['calendar'];
    $sub_array[] = date('Y-m-d',strtotime($row['from_date']));
    $sub_array[] = date('Y-m-d',strtotime($row['to_date']));
    $sub_array[] = $role1Name;
    $sub_array[] = $role2Name;
    $sub_array[] = $row['check_list'];

    $status      = $row['status'];
    if($status == 1)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['audit_area_id'];
	
	$action="<a href='audit_area_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='audit_area_creation&del=$id' title='Delete details' class='delete_audit_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM audit_area_creation";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data
);

echo json_encode($output);
?>