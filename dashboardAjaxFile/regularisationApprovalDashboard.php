<?php
include('../ajaxconfig.php');
@session_start();

if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

$column = array(

    'permission_on_duty_id',
    'department_id',
    'reporting',
    'reason',
    'leave_reason',
    'status'
);

$query = "SELECT * FROM permission_or_on_duty WHERE reporting = '$staffid' and leave_status = 0";
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
    $sub_array[] = $department_name;
    $sub_array[] = $staffName; 
    $sub_array[] = $reason;

    $leave_status  = $row['leave_status'];
	$id   = $row['permission_on_duty_id'];
	
    $action  = '';
    if($leave_status == 0)
	{
        // $action="<a href='permission_approval&upd=$id' title='Edit details'>Approve</a>&nbsp;&nbsp;";
        $action="<button class='btn btn-success' title='Move to Approval page' onclick='regularisation_approve($id)'>Approve</button>";
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