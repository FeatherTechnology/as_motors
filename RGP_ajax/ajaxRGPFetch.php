<?php
include('..\ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 


$column = array(

    'rgp_id',
    'rgp_date',
    'return_date',
    'asset_class',
    'company_id',
    'branch_from',
    'branch_to',
    'asset_name_id',
    'asset_value',
    'reason_rgp',
    'extended_date',
    'extend_reason',
    'status'
);

$query = "SELECT * FROM rgp_creation WHERE 1";
if ($sbranch_id == 'Overall') {
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
                OR rgp_id LIKE '%".$_POST['search']."%'
                OR rgp_date LIKE  '%".$_POST['search']."%'
                OR return_date LIKE  '%".$_POST['search']."%'
                OR asset_class LIKE  '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR branch_from LIKE  '%".$_POST['search']."%'
                OR branch_to LIKE  '%".$_POST['search']."%'
                OR asset_name_id LIKE  '%".$_POST['search']."%'
                OR asset_value LIKE '%".$_POST['search']."%'
                OR reason_rgp LIKE '%".$_POST['search']."%'
                OR extended_date LIKE '%".$_POST['search']."%'
                OR extend_reason LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .= " and branch_from = '".$sbranch_id."'";
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

    // $company_name='';
    // $company_id = $row['company_id'];   
    // $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id)."' and status = 0";
    // $res12 = $con->query($getqry);
    // while($row12 = $res12->fetch_assoc())
    // {
    //    $company_name = $row12["company_name"];        
    // }

    // $company_name='';
    // $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    // $res = $con->query($qry);
    // while($row5 = $res->fetch_assoc())
    // {
    //     $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
    //     $res1 = $con->query($getname) ;
    //     while ($row52 = $res1->fetch_assoc()) {
    //         $company_name = $row52['company_name'];
    //     }
    // }
    
    $branch_from='';
    $getBranchName = $row['branch_from'];   
    $getqry2 = "SELECT * FROM branch_creation WHERE branch_id ='".strip_tags($getBranchName)."' and status = 0";
    $res2 = $con->query($getqry2);
    while($row2 = $res2->fetch_assoc())
    {
       $branch_from = $row2["branch_name"];        
       $company_id_from = $row2["company_id"];        
    }
    
    $company_name_from='';
    $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id_from)."' and status = 0";
    $res3 = $con->query($getqry);
    while($row3 = $res3->fetch_assoc())
    {
       $company_name_from = $row3["company_name"];        
    }

    $branch_to='';
    $getBranchName = $row['branch_to'];   
    $getqry4 = "SELECT * FROM branch_creation WHERE branch_id ='".strip_tags($getBranchName)."' and status = 0";
    $res4 = $con->query($getqry4);
    while($row4 = $res4->fetch_assoc())
    {
       $branch_to = $row4["branch_name"];        
       $company_id_to = $row4["company_id"];        
    }

    $company_name_to='';
    $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id_to)."' and status = 0";
    $res5 = $con->query($getqry);
    while($row5 = $res5->fetch_assoc())
    {
       $company_name_to = $row5["company_name"];        
    }
    
    $asset_name='';
    $getAssetName = $row['asset_name_id'];   
    $getqry6 = "SELECT * FROM asset_register WHERE asset_id ='".strip_tags($getAssetName)."' and status = 0";
    $res6 = $con->query($getqry6);
    while($row6 = $res6->fetch_assoc())
    {
       $asset_name = $row6["asset_name"];        
    }

    $rgp_date = date('d-m-Y',strtotime($row['rgp_date']));
    $extended_date = $row['extended_date']; 
    $return_date = date('d-m-Y',strtotime($row['return_date']));

    //Fetching Asset Classification name
    $asset_class_id = $row['asset_class']; 
    if($asset_class_id == "1"){$asset_class_name = "Plant & Machinary";}
    if($asset_class_id == "2"){$asset_class_name = "Land & Building";}
    if($asset_class_id == "3"){$asset_class_name = "Computer";}
    if($asset_class_id == "4"){$asset_class_name = "Printer and Scanner";}
    if($asset_class_id == "5"){$asset_class_name = "Furniture and Fixtures";}
    if($asset_class_id == "6"){$asset_class_name = "Electrical & fitting";}

    // $sub_array[] = $company_name;
    $sub_array[] = $asset_class_name;
    $sub_array[] = $branch_from .' - '. $company_name_from;
    $sub_array[] = $branch_to .' - '. $company_name_to ;
    $sub_array[] = $rgp_date;
        
    $sub_array[] = $return_date;
    $sub_array[] = $asset_name;
    $sub_array[] = $row['asset_value'];
    $sub_array[] = $row['reason_rgp'];

    if ($extended_date == NULL or $extended_date == '0000-00-00' or $extended_date == '') {
        $sub_array[] = '';
    }else{
        $sub_array[] = date('d-m-Y', strtotime($extended_date));
    }

    if($row['extend_reason'] == ''){
        $sub_array[] = '';
    } else {
        $sub_array[] = $row['extend_reason'];
    }

    $extend_reason = trim($row['extend_reason']);
    
    if($row['extend_status'] == '' and $extend_reason != ''){
        $sub_array[] = 'Pending';
    } elseif($row['extend_status'] == '' and $extend_reason == '') {
        $sub_array[] = '';
    }else{
        $sub_array[] = $row['extend_status'];
    }

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['rgp_id'];

    if ($row['rgp_status'] == 'outward') {
        $asset_id = $row['asset_name_id']; 
        $action = "
            <button onclick = 'inward($id,$asset_id)' title='Inward RGP' class='btn btn-success inward_rgp'><span class='icon-truck'> Inward</span></button>&nbsp;&nbsp;
            <a href='rgp_creation&upd=$id' title='Edit RGP' class='btn btn-info'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
            <a href='rgp_creation&del=$id' title='Delete RGP' class='btn btn-danger delete_rgp'><span class='icon-trash-2'></span></a>&nbsp;&nbsp;
            <button onclick = 'print_rgp($id)' title='Print RGP' class='btn btn-primary'><span class='icon-print'></span></button>";
    }else{
        $action = "
            <button title='Inwarded' disabled class='btn btn-info'>Inwarded <span class='icon-thumbs-up'></span></button>&nbsp;&nbsp;
            <button onclick = 'print_rgp($id)' title='Print RGP' class='btn btn-primary'><span class='icon-print'></span></button>";
    }
	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM rgp_creation";
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