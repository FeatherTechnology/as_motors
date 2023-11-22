<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(
    'audit_assign_id',
    'date_of_audit',
    'department_name',
    'role1',
    'role2',
    'audit_area_id',
    // 'status',
    // 'esi_number', 
    // 'tan_number', 
    // 'pf_number', 
    // 'fax_number', 
    'status'
);

$query = "SELECT a.audit_assign_id,a.date_of_audit,a.department_id,a.role1 as role_id1,d.designation_name as role1,a.role2 as role_id2,d1.designation_name as role2,a.audit_area_id,aac.audit_area,a.status FROM audit_assign a LEFT JOIN designation_creation d ON a.role1 =d.designation_id LEFT JOIN designation_creation d1 ON a.role2 = d1.designation_id LEFT JOIN audit_area_creation aac ON aac.audit_area_id=a.audit_area_id WHERE 1";

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
            
            OR a.audit_assign_id LIKE  '%".$_POST['search']."%'
            OR a.date_of_audit LIKE '%".$_POST['search']."%'
            OR a.department_id LIKE '%".$_POST['search']."%'
            OR a.role1 LIKE '%".$_POST['search']."%'
            OR a.role2 LIKE '%".$_POST['search']."%'
            OR a.audit_area_id LIKE '%".$_POST['search']."%'
            OR a.status LIKE '%".$_POST['search']."%'";
            // OR esi_number LIKE '%".$_POST['search']."%'
            // OR tan_number LIKE '%".$_POST['search']."%'
            // OR pf_number LIKE '%".$_POST['search']."%'
            // OR fax_number LIKE '%".$_POST['search']."%'
            // OR status LIKE '%".$_POST['search']."%' 
        }
    }
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
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }
    $sub_array[] = $row['audit_area'];
    
    // $sub_array[] = $row['department_id'];    
    // department name push array
                        $dep = $row['department_id'];
                        // print_r($dep);
                        $departid = explode(",", $dep);
                        $department_name   = array();
                        foreach($departid as $departmentid) {
                        $deptid = trim($departmentid);
                        $department_name1 = "SELECT department_name FROM department_creation WHERE department_id IN ($deptid) and status = 0";
                        $res2 = $mysqli->query($department_name1);


                        $row2 = $res2->fetch_assoc();
                        $department_name[] = $row2['department_name'];



                        }
                        // print_r($department_name);


                        $dept_name                 = $department_name;  

                        $deptname = implode(', ', $dept_name); 
                        array_push($sub_array,$deptname);
                       
     $sub_array[] = $row['date_of_audit'];
 
    $sub_array[] = $row['role1'];
    $sub_array[] = $row['role2'];

    $auditstsQry = $mysqli->query("SELECT * FROM `audit_assign_ref` WHERE `audit_assign_id` = 2 &&  `audit_status` = 0 && `auditee_followup_status` != 1");
    if(mysqli_num_rows($auditstsQry)>0){
        // $auditstsfetch = $auditstsQry->fetch_assoc();
        $sub_array[] = 'Audit Pending';
    }else{
        $sub_array[] = 'Audit Completed';
    }




    // $sub_array[] = $row['pan_number'];
    // $sub_array[] = $row['esi_number'];
    // $sub_array[] = $row['tan_number'];
    // $sub_array[] = $row['pf_number'];  
    // $sub_array[] = $row['fax_number'];
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['audit_assign_id'];
	
	$action="<a href='audit_assign&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='audit_assign&del=$id' title='Delete details' class='delete_audit_assign'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
    
}

function count_all_data($connect)
{
    $query     = "SELECT a.audit_assign_id,a.date_of_audit,a.department_id,a.role1 as role_id1,d.designation_name as role1,a.role2 as role_id2,d1.designation_name as role2,a.audit_area_id,aac.audit_area,a.status FROM audit_assign a LEFT JOIN designation_creation d ON a.role1 =d.designation_id LEFT JOIN designation_creation d1 ON a.role2 = d1.designation_id LEFT JOIN audit_area_creation aac ON aac.audit_area_id=a.audit_area_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}




$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data,
    // 'deptname' => $deptname
);


echo json_encode($output);
?>





