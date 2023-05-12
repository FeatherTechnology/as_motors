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
    'maintenance_checklist_id',
    'company_id',
    'date_of_inspection',
    'asset_details',
    'checklist',
    'role1',
    'role2',
    'status'
);

$query = "SELECT * FROM maintenance_checklist WHERE 1 ";
if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="")
    {
        if (isset($_POST['search'])) {
            
            if($_POST['search']=="Active")
            {
                $query .=" WHERE status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .=" WHERE status=1 ";
            }
            else{	
                $query .= "
                WHERE maintenance_checklist_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE '%".$_POST['search']."%'
                OR date_of_inspection LIKE '%".$_POST['search']."%'
                OR asset_details LIKE '%".$_POST['search']."%'
                OR checklist LIKE '%".$_POST['search']."%'
                OR role1 LIKE '%".$_POST['search']."%'
                OR role2 LIKE '%".$_POST['search']."%' ";
            }
        }
    }
    
}else{
    $query .=" WHERE company_id= '".$sbranch_id."' ";
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

    $role1Name='';
    $role1Id = $row['role1'];   
    $getAuditorName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role1Id)."' and status = 0";
    $res12 = $con->query($getAuditorName);
    while($row12 = $res12->fetch_assoc())
    {
       $role1Name = $row12["designation_name"];        
    }
    
    $role2Name='';
    $role2Id = $row['role2'];   
    $getAuditeeName = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($role2Id)."' and status = 0";
    $res14 = $con->query($getAuditeeName);
    while($row14 = $res14->fetch_assoc())
    {
       $role2Name = $row14["designation_name"];        
    }

    if($row['checklist'] == "pm_checklist"){$checklist = "PM Checklist";}
    if($row['checklist'] == "bm_checklist"){$checklist = "BM Checklist";}
    
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $row['date_of_inspection'];
    $sub_array[] = $asset_name;
    $sub_array[] = $checklist;
    $sub_array[] = $role1Name;
    $sub_array[] = $role2Name;
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['maintenance_checklist_id'];
	
	$action="<a href='maintenance_checklist&view=$id' title='View details'><span class='icon-eye'></span></a>&nbsp;&nbsp; 
    <a href='maintenance_checklist&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='maintenance_checklist&del=$id' title='Delete details' class='delete_maintenance_checklist'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM maintenance_checklist";
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