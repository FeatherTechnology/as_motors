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

    'kra_id',
    'company_id',
    'department_id',
    'designation_id',
    'status'
);

$query = "SELECT * FROM kra_creation WHERE 1";
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
                OR kra_id LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR department_id LIKE  '%".$_POST['search']."%'
                OR designation_id LIKE '%".$_POST['search']."%'
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
    $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row['company_id']."' ";
    $res1 = $con->query($getname) ;
    while ($row52 = $res1->fetch_assoc()) {
        $company_name = $row52['company_name'];
    }

    $department_name='';
    $getDepartmentName = $row['department_id'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $department_name = $row12["department_name"];        
    }

    $designation_name='';
    $getDesignationName = $row['designation_id'];   
    $getqry = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($getDesignationName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $designation_name = $row12["designation_name"];        
    }
    
    $sub_array[] = $company_name;
    $sub_array[] = $department_name;
    $sub_array[] = $designation_name;
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['kra_id'];
	
	$action="<a href='kra_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='kra_creation&del=$id' title='Delete details' class='delete_kra_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM kra_creation";
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