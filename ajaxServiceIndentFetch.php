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

    'service_indent_id',
    'company_id',
    'date_of_indent',
    'asset_class',
    'asset_name1',
    'asset_value',
    'vendor_address',
    'company_address',
    'reason_for_indent',
    'expected_to_arrive',
    'stock_in_out',
    'status'
);

$query = "SELECT * FROM service_indent WHERE 1";
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
                OR service_indent_id LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR date_of_indent LIKE  '%".$_POST['search']."%'
                OR asset_class LIKE  '%".$_POST['search']."%'
                OR asset_name1 LIKE '%".$_POST['search']."%'
                OR asset_value LIKE '%".$_POST['search']."%'
                OR vendor_address LIKE '%".$_POST['search']."%'
                OR company_address LIKE '%".$_POST['search']."%'
                OR reason_for_indent LIKE '%".$_POST['search']."%'
                OR expected_to_arrive LIKE '%".$_POST['search']."%'
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
    $stock_in_out = $row["stock_in_out"];
    if($stock_in_out==1)
    {
        if($sno!="")
        {
            $sub_array[] = $sno;
        }

        //Fetching Asset Classification name
        $asset_class_id = $row['asset_class']; 
        if($asset_class_id == "1"){$asset_class_name = "Plant & Machinary";}
        if($asset_class_id == "2"){$asset_class_name = "Land & Building";}
        if($asset_class_id == "3"){$asset_class_name = "Computer";}
        if($asset_class_id == "4"){$asset_class_name = "Printer and Scanner";}
        if($asset_class_id == "5"){$asset_class_name = "Furniture and Fixtures";}
        if($asset_class_id == "6"){$asset_class_name = "Electrical & fitting";}

        $asset_name1='';
        $getAssetName= $row['asset_name1'];   
        $getqry = "SELECT asset_name FROM asset_register WHERE asset_id ='".strip_tags($getAssetName)."' and status = 0";
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc())
        {
        $asset_name1 = $row12["asset_name"];        
        }

        $sub_array[] = $row['date_of_indent'];
        $sub_array[] = $asset_class_name;
        $sub_array[] = $asset_name1;
        $sub_array[] = $row['asset_value'];
        $sub_array[] = $row['vendor_address'];
        $sub_array[] = $row['company_address'];
        $sub_array[] = $row['reason_for_indent'];
        $sub_array[] = $row['expected_to_arrive'];
        
        $status      = $row['status'];
        if($status == 1)
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
        }
        else
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
        }
        $id   = $row['service_indent_id'];
        
        $action="<a href='service_indent&stock=$id'><button type='button'  class='btn btn-success approvepo' title='Edit details'><span class='icon-check-circle'></span>&nbsp;Closed Service Indent</button> </a>&nbsp; <a href='service_indent&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
        <a href='service_indent&del=$id' title='Delete details' class='delete_service_indent'><span class='icon-trash-2'></span></a>";

        $sub_array[] = $action;
        $data[]      = $sub_array;
        $sno = $sno + 1;
    }else if($stock_in_out==2)
    {
        if($sno!="")
        {
            $sub_array[] = $sno;
        }
        
        //Fetching Asset Classification name
        $asset_class_id = $row['asset_class']; 
        if($asset_class_id == "1"){$asset_class_name = "Plant & Machinary";}
        if($asset_class_id == "2"){$asset_class_name = "Land & Building";}
        if($asset_class_id == "3"){$asset_class_name = "Computer";}
        if($asset_class_id == "4"){$asset_class_name = "Printer and Scanner";}
        if($asset_class_id == "5"){$asset_class_name = "Furniture and Fixtures";}
        if($asset_class_id == "6"){$asset_class_name = "Electrical & fitting";}
    
        $asset_name1='';
        $getAssetName= $row['asset_name1'];   
        $getqry = "SELECT asset_name FROM asset_register WHERE asset_id ='".strip_tags($getAssetName)."' and status = 0";
        $res12 = $con->query($getqry);
        while($row12 = $res12->fetch_assoc())
        {
           $asset_name1 = $row12["asset_name"];        
        }
    
        $sub_array[] = $row['date_of_indent'];
        $sub_array[] = $asset_class_name;
        $sub_array[] = $asset_name1;
        $sub_array[] = $row['asset_value'];
        $sub_array[] = $row['vendor_address'];
        $sub_array[] = $row['company_address'];
        $sub_array[] = $row['reason_for_indent'];
        $sub_array[] = $row['expected_to_arrive'];
        
        $status      = $row['status'];
        if($status == 1)
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
        }
        else
        {
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
        }
        $id   = $row['service_indent_id'];
        
        // $action="<a href='service_indent&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
        // <a href='service_indent&del=$id' title='Delete details' class='delete_service_indent'><span class='icon-trash-2'></span></a>";
    
        $sub_array[] = '-';
        $data[]      = $sub_array;
        $sno = $sno + 1;
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM service_indent";
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