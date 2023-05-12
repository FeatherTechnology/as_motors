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
    // 'audit_checklist_id',
    'audit_area_id',
    'department',
    'auditor',
    'auditee',
    'status'
);
$query = "SELECT * FROM audit_checklist WHERE 1 ";
if ($sbranch_id == 'Overall') {
    $query .= '';
    if($_POST['search']!=""){
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
                OR department LIKE  '%".$_POST['search']."%'
                OR auditor LIKE  '%".$_POST['search']."%'
                OR auditee LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
    
}else{
    
    $sdepartment_id = array();
    $branchQry = "SELECT department_creation.* FROM department_creation INNER JOIN audit_checklist ON department_creation.department_id = audit_checklist.department WHERE department_creation.company_id = '".$sbranch_id."' ";
    $branchRes = $con->query($branchQry);
        while($branchrow = $branchRes->fetch_assoc())
        {
            $branch_id[] = $branchrow["company_id"];
            $sdepartment_id[] = $branchrow["department_id"];
        }
    $query .=" and (";
    for ($l = 0; $l < count($sdepartment_id);$l++){
        $query .=" department= '".$sdepartment_id[$l]."' ";
        if ($l < count($sdepartment_id)-1) {
            $query .= " or";
        }
    }
    $query .=" ) ";
}
if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= '';
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
    
    $audit_area='';
    $getAuditAreaName = $row['audit_area_id'];
    $getqry = "SELECT audit_area FROM audit_area_creation WHERE audit_area_id ='".strip_tags($getAuditAreaName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $audit_area = $row12["audit_area"];
    }

    $departmentName1 = explode(",", $row['department']);
    foreach($departmentName1 as $departmentName) {
        $departmentName = trim($departmentName);
        $getDeptName = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentName)."' and status = 0";
        $res14 = $con->query($getDeptName);
        while($row14 = $res14->fetch_assoc())
        {
           $department_name[] = $row14["department_name"];      
        }
    }

    $role1Name='';
    $role1Id = $row['auditor'];   
    $getAuditorName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role1Id)."' and status = 0";
    $res12 = $con->query($getAuditorName);
    while($row12 = $res12->fetch_assoc())
    {
       $role1Name = $row12["designation_name"];        
    }
    
    $role2Name='';
    $role2Id = $row['auditee'];   
    $getAuditeeName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role2Id)."' and status = 0";
    $res14 = $con->query($getAuditeeName);
    while($row14 = $res14->fetch_assoc())
    {
       $role2Name = $row14["designation_name"];        
    }

    $sub_array[] = $audit_area;
    $sub_array[] = $department_name;
    $sub_array[] = $role1Name;
    $sub_array[] = $role2Name;
    $status      = $row['status'];
    if($status == 1)
    {
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
    }
    else
    {
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
    }
    $id   = $row['audit_checklist_id'];
    $action="<a href='audit_checklist&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp;
    <a href='audit_checklist&del=$id' title='Delete details' class='delete_audit_creation'><span class='icon-trash-2'></span></a>";
    $sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}
function count_all_data($connect)
{
    $query     = "SELECT * FROM audit_checklist";
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