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
    
    'vehicle_details_id',
    'company_id',
    'vehicle_code',
    'vehicle_name',
    'vehicle_number',
    'date_of_purchase',
    'fitment_upto',
    'insurance_upto',
    'asset_value',
    'book_value_as_on',
    'status'
);

$query = "SELECT * FROM vehicle_details where 1";
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
                OR vehicle_details_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR vehicle_code LIKE '%".$_POST['search']."%'
                OR vehicle_name LIKE '%".$_POST['search']."%'
                OR vehicle_number LIKE '%".$_POST['search']."%'
                OR date_of_purchase LIKE '%".$_POST['search']."%'
                OR fitment_upto LIKE '%".$_POST['search']."%'
                OR insurance_upto LIKE '%".$_POST['search']."%'
                OR asset_value LIKE '%".$_POST['search']."%'
                OR book_value_as_on LIKE '%".$_POST['search']."%'
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
    
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $row['vehicle_code'];
    $sub_array[] = $row['vehicle_name'];
    $sub_array[] = $row['vehicle_number'];
    $sub_array[] = $row['date_of_purchase'];
    $sub_array[] = $row['fitment_upto'];
    $sub_array[] = $row['insurance_upto'];
    $sub_array[] = $row['asset_value'];
    $sub_array[] = $row['book_value_as_on'];
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['vehicle_details_id'];
	
	$action="<a href='vehicle_details&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='vehicle_details&del=$id' title='Delete details' class='delete_vehicle_details'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM vehicle_details";
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