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

    'transfer_location_id',
    'company_id',
    'department_id',
    'staff_code',
    'staff_id',
    'dot',
    'transfer_location',
    'transfer_effective_from',
    'file',
    'status'
);

$query = "SELECT * FROM transfer_location WHERE 1";
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
                OR staff_code LIKE  '%".$_POST['search']."%'
                OR staff_id LIKE  '%".$_POST['search']."%'
                OR dot LIKE '%".$_POST['search']."%'
                OR transfer_location LIKE  '%".$_POST['search']."%'
                OR transfer_effective_from LIKE  '%".$_POST['search']."%'
                OR file LIKE  '%".$_POST['search']."%'
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

    $staffCode='';
    $getStaffCode = $row['staff_code'];   
    $getqry = "SELECT emp_code FROM staff_creation WHERE staff_id ='".strip_tags($getStaffCode)."' and status = 0"; 
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $staffCode = $row12["emp_code"];        
    }

    $transfer_branch_name='';
    $transfer_company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['transfer_location']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row8 = $res->fetch_assoc())
    {
        $transfer_branch_name = $row8['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row8['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row10 = $res1->fetch_assoc()) {
            $transfer_company_name = $row10['company_name'];
        }
    }
    
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $department_name;
    $sub_array[] = $staffCode;
    $sub_array[] = $row['staff_id'];
    $sub_array[] = $row['dot'];   
    $sub_array[] = $transfer_company_name.' - '.$transfer_branch_name;
    $sub_array[] = $row['transfer_effective_from'];
    $sub_array[] = "<a href='uploads/transfer_location/".$row['file']."' target='_blank'>".$row['file']."</a>";

    $status      = $row['status'];
    if($status == 1)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['transfer_location_id'];
	
	$action="<a href='transfer_location&upd=$id' title='Edit details'><span class='icon-border_color'></span></a> &nbsp;&nbsp; 
	<a href='transfer_location&del=$id' title='Delete details' class='delete_transfer_location'><span class='icon-trash-2'></span></a> &nbsp;&nbsp; 
    <span onclick = 'print_transfer_location($id)' title='Print Transfer Location'><span class='icon-print'></span></button>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM transfer_location";
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