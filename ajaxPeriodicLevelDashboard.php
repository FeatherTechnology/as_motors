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
    
    'periodic_level_id',
    'company_id',
    'periodic_date',
    'asset_details',
    'status'
);

$query = "SELECT * FROM periodic_level where 1";
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
                OR periodic_level_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR periodic_date LIKE '%".$_POST['search']."%'
                OR asset_details LIKE '%".$_POST['search']."%'
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

    $asset_name='';
    $assetDetails = $row['asset_details'];   
    $getqry7 = "SELECT asset_name FROM asset_register WHERE asset_id ='".strip_tags($assetDetails)."' and status = 0";
    $res7 = $con->query($getqry7);
    while($row7 = $res7->fetch_assoc())
    {
       $asset_name = $row7["asset_name"];        
    }
 
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $row['periodic_date'];
    $sub_array[] = $asset_name;

    // $status      = $row['status'];
    // if($status == 1)
	// {
	// $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	// }
	// else
	// {
    // $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	// }
	// $id   = $row['periodic_level_id'];
	
	// $action="<a href='periodic_level&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	// <a href='periodic_level&del=$id' title='Delete details' class='delete_periodic_level'><span class='icon-trash-2'></span></a>";

	// $sub_array[] = $action;
    
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM periodic_level";
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