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

    'permission_on_duty_id',
    'company_id',
    'department_id',
    'staff_id',
    'staff_code',
    'reporting',
    'reason',
    'permission_from_time',
    'permission_to_time',
    'permission_date',
    'on_duty_place',
    'leave_date',
    'leave_reason',
    'status'
);

$query = "SELECT * FROM permission_or_on_duty WHERE 1";
if($sbranch_id == 'Overall'){
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
                OR company_id LIKE  '%".$_POST['search']."%'
                OR department_id LIKE  '%".$_POST['search']."%'
                OR staff_id LIKE  '%".$_POST['search']."%'
                OR staff_code LIKE  '%".$_POST['search']."%'
                OR reporting LIKE '%".$_POST['search']."%'
                OR reason LIKE  '%".$_POST['search']."%'
                OR permission_from_time LIKE  '%".$_POST['search']."%'
                OR permission_to_time LIKE  '%".$_POST['search']."%'
                OR permission_date LIKE  '%".$_POST['search']."%'
                OR on_duty_place LIKE  '%".$_POST['search']."%'
                OR leave_date LIKE  '%".$_POST['search']."%'
                OR leave_reason LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .=" and company_id= '".$sbranch_id."' ";
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

    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $branch_name = $row5['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }

    $department_name='';
    $getDepartmentName = $row['department_id'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $department_name = $row12["department_name"];        
    }

    $staffName='';
    $getStaffName = $row['staff_id'];   
    $getqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($getStaffName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $staffName = $row12["staff_name"];        
    }

    $reason='';
    $reasonValue = $row['reason'];
    if($reasonValue == "personal_reason"){ $reason = "Personal Permission"; }
    if($reasonValue == "leave"){ $reason = "Leave"; }
    if($reasonValue != "personal_reason" && $reasonValue != "leave") { $reason = $row['reason']; }
    
    $sub_array[] = $row['regularisation_id'];
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $department_name;
    $sub_array[] = $staffName;
    $sub_array[] = $row['staff_code'];
    $sub_array[] = $row['reporting'];   
    $sub_array[] = $reason;

    $leave_status  = $row['leave_status'];
    if($leave_status == 0)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Requested</span></span>";
	}
	elseif($leave_status == 1)
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Approved</span></span>";
	}
	elseif($leave_status == 2)
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Rejected</span></span>";
	}

    $status  = $row['status'];
    if($status == 1)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['permission_on_duty_id'];
	
    $action  = '';
    if($leave_status == 0)
	{
        $action="<a href='permission_approval&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp;";
	}

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM permission_or_on_duty";
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