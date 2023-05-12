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

    'diesel_slip_id',
    'company_id',
    'vehicle_number',
    'previous_km',
    'previous_km_date',
    'present_km',
    'present_km_date',
    'total_km_run',
    'diesel_amount',
    'status'
);

$query = "SELECT * FROM diesel_slip where 1";
if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {
            
            if($_POST['search']=="Active")
            {
                $query .=" and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .=" and status=1 ";
            }
            
            else{	
                
                $query .= "
                OR diesel_slip_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR vehicle_number LIKE '%".$_POST['search']."%'
                OR previous_km LIKE '%".$_POST['search']."%'
                OR previous_km_date LIKE '%".$_POST['search']."%'
                OR present_km LIKE '%".$_POST['search']."%'
                OR present_km_date LIKE '%".$_POST['search']."%'
                OR total_km_run LIKE '%".$_POST['search']."%'
                OR diesel_amount LIKE '%".$_POST['search']."%'
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

    $branch_name='';
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

    $vehicle_number='';
    $vehicleNumber = $row['vehicle_number'];
    $getqry = "SELECT vehicle_number FROM vehicle_details WHERE vehicle_details_id ='".strip_tags($vehicleNumber)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $vehicle_number = $row12["vehicle_number"];
    }
    
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $vehicle_number;
    $sub_array[] = $row['previous_km'];
    $sub_array[] = $row['previous_km_date'];
    $sub_array[] = $row['present_km'];
    $sub_array[] = $row['present_km_date'];
    $sub_array[] = $row['total_km_run'];
    $sub_array[] = $row['diesel_amount'];
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['diesel_slip_id'];
	
    $action="<a href='diesel_slip&upd=$id' title='Edit details'><span class='icon-border_color'></span></a> &nbsp;&nbsp; 
	<a href='diesel_slip&del=$id' title='Delete details' class='delete_diesel_slip'><span class='icon-trash-2'></span></a> &nbsp;&nbsp; 
    <span onclick = 'print_diesel_slip($id)' title='Print Diesel Slip'><span class='icon-print'></span></button>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM diesel_slip";
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