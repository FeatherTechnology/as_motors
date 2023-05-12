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

    'asset_details_id',
    'company_id',
    'branch_id',
    'classification',
    'asset_name',
    'asset_value',
    'dou',
    'depreciation',
    'as_on',
    'spare_names',
    'status'
);

$query = "SELECT * FROM asset_details WHERE 1";
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
                OR asset_details_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR branch_id LIKE  '%".$_POST['search']."%'
                OR classification LIKE  '%".$_POST['search']."%'
                OR asset_name LIKE  '%".$_POST['search']."%'
                OR asset_value LIKE  '%".$_POST['search']."%'
                OR dou LIKE  '%".$_POST['search']."%'
                OR depreciation LIKE  '%".$_POST['search']."%'
                OR as_on LIKE '%".$_POST['search']."%'
                OR spare_names LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .= " and branch_id = '".$sbranch_id."'";
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
    $company_id = $row['company_id'];   
    $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $company_name = $row12["company_name"];        
    }
    
    $branch_name='';
    $getBranchName = $row['branch_id'];   
    $getqry2 = "SELECT * FROM branch_creation WHERE branch_id ='".strip_tags($getBranchName)."' and status = 0";
    $res2 = $con->query($getqry2);
    while($row2 = $res2->fetch_assoc())
    {
       $branch_name = $row2["branch_name"];        
    }
    
    $asset_name='';
    $getAssetName = $row['asset_name'];   
    $getqry3 = "SELECT * FROM asset_register WHERE asset_id ='".strip_tags($getAssetName)."' and status = 0";
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc())
    {
       $asset_name = $row3["asset_name"];        
    }

    // $spare_name[]='';  
    // $spareId1 = explode(",", $row['spare_names']);
    // foreach ($spareId1 as $spareId) {
    //     $getqry3 = "SELECT * FROM spare_creation WHERE spare_id ='" . strip_tags($spareId) . "' and status = 0";
    //     $res3 = $con->query($getqry3);
    //     while ($row3 = $res3->fetch_assoc()) {
    //         $spare_name[] = $row3["spare_name"];
    //     }
    // }

    $spare_names = array();
    $spareId1 = explode(",", $row['spare_names']);
    foreach ($spareId1 as $spareId) {
        $getqry4 = "SELECT * FROM spare_creation WHERE spare_id ='" . strip_tags($spareId) . "' and status = 0";
        $res4 = $con->query($getqry4);
        while ($row4 = $res4->fetch_assoc()) {
            $spare_names[] = $row4["spare_name"];
        }
    }

    //Fetching Asset Classification name
    $asset_class_id = $row['classification']; 
    if($asset_class_id == "1"){$asset_class_name = "Plant & Machinary";}
    if($asset_class_id == "2"){$asset_class_name = "Land & Building";}
    if($asset_class_id == "3"){$asset_class_name = "Computer";}
    if($asset_class_id == "4"){$asset_class_name = "Printer and Scanner";}
    if($asset_class_id == "5"){$asset_class_name = "Furniture and Fixtures";}
    if($asset_class_id == "6"){$asset_class_name = "Electrical & fitting";}

    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $asset_class_name;
    $sub_array[] = $asset_name;
    $sub_array[] = $row['dou'];
    $sub_array[] = $row['asset_value'];
    $sub_array[] = $row['depreciation'];
    $sub_array[] = $row['as_on'];
    $sub_array[] = $spare_names;

    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['asset_details_id'];
	
	$action="<a href='asset_details&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='asset_details&del=$id' title='Delete details' class='delete_asset_details'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect){
    $query     = "SELECT * FROM asset_details";
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