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

    'asset_id',
    'company_id',
    'asset_classification',
    'asset_name',
    'dop',
    'asset_nature',
    'asset_value',
    'maintenance',
    'status'
);

$query = "SELECT * FROM asset_register WHERE 1";
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
                OR asset_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR asset_classification LIKE  '%".$_POST['search']."%'
                OR asset_name LIKE  '%".$_POST['search']."%'
                OR dop LIKE  '%".$_POST['search']."%'
                OR asset_nature LIKE '%".$_POST['search']."%'
                OR asset_value LIKE '%".$_POST['search']."%'
                OR maintenance LIKE '%".$_POST['search']."%'
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
    
    //Fetching Asset Classification name
    $asset_class_id = $row['asset_classification']; 
    if($asset_class_id == "1"){$asset_class_name = "Plant & Machinary";}
    if($asset_class_id == "2"){$asset_class_name = "Land & Building";}
    if($asset_class_id == "3"){$asset_class_name = "Computer";}
    if($asset_class_id == "4"){$asset_class_name = "Printer and Scanner";}
    if($asset_class_id == "5"){$asset_class_name = "Furniture and Fixtures";}
    if($asset_class_id == "6"){$asset_class_name = "Electrical & fitting";}

    $sub_array[] = $company_name;
    $sub_array[] = $asset_class_name;
    $sub_array[] = $row['asset_name'];
    $sub_array[] = $row['dop'];

    //Fetchin Asset Nature Name
    $asset_nature_id = $row['asset_nature'];
    if($asset_nature_id == "1"){$asset_nature_name = "Immoveable";}
    if($asset_nature_id == "2"){$asset_nature_name = "Moveable";}

    $sub_array[] = $asset_nature_name;
    $sub_array[] = $row['asset_value'];

    //Fetchin Maintenance 
    $maintenance_id = $row['maintenance'];
    if($maintenance_id == "1"){$maintenance = "Yes";}
    if($maintenance_id == "2"){$maintenance = "No";}
    $sub_array[] = $maintenance;

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['asset_id'];
	
	$action="<a href='asset_register&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='asset_register&del=$id' title='Delete details' class='delete_asset_register'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM asset_register";
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