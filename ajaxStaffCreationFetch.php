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

    'staff_id',
    'staff_name',
    'company_id',
    'designation',
    'reporting',
    'emp_code',
    'department',
    'doj',
    'dob',
    'krikpi',
    'key_skills',
    'contact_number',
    'email_id',
    'status'
);

$query = "SELECT * FROM staff_creation WHERE 1";
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
                OR staff_id LIKE  '%".$_POST['search']."%'
                OR staff_name LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR designation LIKE '%".$_POST['search']."%'
                OR reporting LIKE '%".$_POST['search']."%'
                OR emp_code LIKE  '%".$_POST['search']."%'
                OR department LIKE  '%".$_POST['search']."%'
                OR doj LIKE  '%".$_POST['search']."%'
                OR dob LIKE  '%".$_POST['search']."%'
                OR krikpi LIKE  '%".$_POST['search']."%'
                OR key_skills LIKE  '%".$_POST['search']."%'
                OR contact_number LIKE  '%".$_POST['search']."%'
                OR email_id LIKE  '%".$_POST['search']."%'
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
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }


    $department_name='';
    $getDepartmentName = $row['department'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $department_name = $row12["department_name"];        
    }

    $designation_name='';
    $getDesignationName = $row['designation'];   
    $getqry = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($getDesignationName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $designation_name = $row12["designation_name"];        
    }

    $reporting='';
    $getReporting = $row['reporting'];   
    $getqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($getReporting)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $reporting = $row12["staff_name"];        
    }
    
    $sub_array[] = $row['staff_name'];
    $sub_array[] = $company_name;
    $sub_array[] = $department_name;
    $sub_array[] = $designation_name;
    $sub_array[] = $reporting;
    $sub_array[] = $row['doj'];
    
    $krakpi_id = $row['krikpi'];
    $krakpi_name='';
    $designation_id='';
    $getqry = "SELECT * FROM krakpi_creation WHERE krakpi_id ='".strip_tags($krakpi_id)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $designation_id = $row12["designation"];        
    }
    $getqry = "SELECT * FROM designation_creation WHERE designation_id ='".strip_tags($designation_id)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $krakpi_name = $row12["designation_name"];        
    }
    $sub_array[] = $krakpi_name;

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['staff_id'];
	
	$action="<a href='staff_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='staff_creation&del=$id' title='Delete details' class='delete_staff_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM staff_creation";
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