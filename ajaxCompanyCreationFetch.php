<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(
    'company_id',
    'company_name',
    'company_status',
    'cin',
    'address1',
    'email_id',
    'pan_number',
    'esi_number', 
    'tan_number', 
    'pf_number', 
    'fax_number', 
    'status'
);

$query = "SELECT * FROM company_creation WHERE 1";

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
            OR company_name LIKE '%".$_POST['search']."%'
            OR company_status LIKE '%".$_POST['search']."%'
            OR cin LIKE '%".$_POST['search']."%'
            OR address1 LIKE '%".$_POST['search']."%'
            OR email_id LIKE '%".$_POST['search']."%'
            OR pan_number LIKE '%".$_POST['search']."%'
            OR esi_number LIKE '%".$_POST['search']."%'
            OR tan_number LIKE '%".$_POST['search']."%'
            OR pf_number LIKE '%".$_POST['search']."%'
            OR fax_number LIKE '%".$_POST['search']."%'
            OR status LIKE '%".$_POST['search']."%' ";
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
    
    $sub_array[] = $row['company_name'];
    $sub_array[] = $row['company_status'];
    $sub_array[] = $row['cin'];
    $sub_array[] = $row['address1'];
    $sub_array[] = $row['email_id'];
    $sub_array[] = $row['pan_number'];
    $sub_array[] = $row['esi_number'];
    $sub_array[] = $row['tan_number'];
    $sub_array[] = $row['pf_number'];  
    $sub_array[] = $row['fax_number'];
    
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['company_id'];
	
	$action="<a href='company_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a title='Delete details' class='delete_company_creation' data-value='$id'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM company_creation";
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